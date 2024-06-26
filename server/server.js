const express = require('express');
const path = require('path');
const bodyParser = require('body-parser');
const bcrypt = require('bcrypt');
const session = require('express-session');
const connection = require('./config/db');
const { app, server, io } = require('./config/socket');
const { log } = require('console');

const PORT = 3000;

// Set EJS as the view engine
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, '..', 'views'));

// Middleware
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

app.use(session({
  secret: '776fccdf2c66ec210832b1fd1a0c2a70c8ed3729cdeb28f578829f67aa57b2c5cf8ed0dab09127f9aefdb333624c4ba6ed1eae2e6e89317d5b5c62c0fa477300', // Replace with a strong secret key
  resave: false,
  saveUninitialized: true,
  cookie: { secure: false } // Set secure: true if using HTTPS
}));

// Serve static files from the public directory
app.use(express.static(path.join(__dirname, '..', 'public')));

// Middleware to check if user is logged in
function checkAuth(req, res, next) {
  if (req.session.user) {
    next();
  } else {
    res.redirect('/signin');
  }
}

// API route
app.get('/api/data', (req, res) => {
  res.json({ message: 'Hello from the Server Side!' });
});

// Route to render EJS template
app.get('/', (req, res) => {
  console.log("req.session.user",req.session.user);
  if (req.session.user) {
    res.redirect('/chat-history');
  } else {
    res.redirect('/signin');
  }
});

// Sign-In route
app.get('/signin', (req, res) => {
  if (req.session.user) {
    res.redirect('/chat-history');
  } else {
    res.render('signin');
  }
});

app.post('/signin', (req, res) => {
  const { email, password } = req.body;
  const query = 'SELECT * FROM users WHERE email = ?';
  connection.query(query, [email], async (err, results) => {
    if (err) {
      console.error('Error retrieving user:', err);
      return res.status(500).json({ status: 'error', message: 'Internal Server Error' });
    }

    if (results.length > 0) {
      const user = results[0];

      try {
        const match = await bcrypt.compare(password, user.user_password);

        if (match) {
          req.session.user = { id: user.id, email: user.email };
          res.status(200).json({ status: 'success', message: 'User signed in successfully' });
        } else {
          res.status(401).json({ status: 'fail', message: 'Incorrect email or password' });
        }
      } catch (error) {
        console.error('Error comparing passwords:', error);
        res.status(500).json({ status: 'error', message: 'Internal Server Error' });
      }
    } else {
      res.status(401).json({ status: 'fail', message: 'Incorrect email or password' });
    }
  });
});

// Sign-Up route
app.get('/signup', (req, res) => {
    res.render('signup');
});

app.post('/signup', async (req, res) => {
  const { email, name, password } = req.body;

  if (!email || !name || !password) {
    return res.status(400).json({ status: 'fail', message: 'All fields are required' });
  }

  try {
    const hashedPassword = await bcrypt.hash(password, 10);

    const query = 'INSERT INTO users (email, username, user_password) VALUES (?, ?, ?)';
    connection.query(query, [email, name, hashedPassword], (err, results) => {
      if (err) {
        console.error('Error inserting data into MySQL:', err);
        return res.status(500).json({ status: 'error', message: 'Internal Server Error' });
      }

      res.status(200).json({ status: 'success', message: 'User registered successfully' });
    });
  } catch (error) {
    console.error('Error hashing password:', error);
    res.status(500).json({ status: 'error', message: 'Internal Server Error' });
  }
});
app.post('/clientList', async (req, res) => {
  const query = 'SELECT username,email,id FROM users';
  connection.query(query, async (err, results) => {
    if (err) {
      console.error('Error retrieving user:', err);
      return res.status(500).json({ status: 'error', message: 'Internal Server Error' });
    }

    if (results.length > 0){
      const clientList = results;
      res.status(200).json(clientList);
    }
  })
})
app.post('/sendChat', async (req, res) => {
  const {chatInputVal,chatUserId,currentUserId} = req.body;
  const query = 'INSERT INTO chats (user_id, to_user_id, message) VALUES (?, ?, ?)';
    connection.query(query, [currentUserId, chatUserId, chatInputVal], (err, results) => {
      if (err) {
        console.error('Error inserting data into MySQL:', err);
        return res.status(500).json({ status: 'error', message: 'Internal Server Error' });
      }
      io.emit('sendMessage', { currentUserId, chatUserId, message:chatInputVal });
      res.status(200).json({ status: 'success', message: 'Message sent successfully' });
    });

})


app.post('/typingEvent', async (req, res) => {
  const {currentUserId,chatUserId} = req.body;
  io.emit('typing', { currentUserId, chatUserId });
})

app.post('/stopTyping', async (req, res) => {
  const {currentUserId,chatUserId} = req.body;
  io.emit('stopTyping', { currentUserId, chatUserId });
})

app.post('/getChats', async (req, res) => {
  const { currentUserId, chatUserId } = req.body;

  const query = `
    SELECT * 
    FROM chats 
    WHERE (user_id = ? AND to_user_id = ?) 
       OR (user_id = ? AND to_user_id = ?) 
       ORDER BY created ASC
  `;

  connection.query(query, [currentUserId, chatUserId, chatUserId, currentUserId], (err, results) => {
    if (err) {
      console.error('Error retrieving chats:', err);
      return res.status(500).json({ status: 'error', message: 'Internal Server Error' });
    }
    console.log("results: ",results);
    res.status(200).json(results);
  });
});


// Chat History route
app.get('/chat-history', checkAuth, (req, res) => {
  res.render('chat-history');
});

// Logout route
app.get('/logout', (req, res) => {
  req.session.destroy((err) => {
    if (err) {
      return res.status(500).json({ status: 'error', message: 'Failed to log out' });
    }
    res.redirect('/signin');
  });
});

// Start the server
server.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
