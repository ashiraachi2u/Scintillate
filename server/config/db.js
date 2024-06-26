const mysql = require('mysql2');

// Create the connection to the database
const connection = mysql.createConnection({
    host: '13.201.46.63', 
    user: 'ashir',
    password: 'Ashir@123',
    database: 'Scintillate_db'
});

// Connect to the database
connection.connect((err) => {
    if (err) {
        console.error('Error connecting to the database:', err);
        return;
    }
    console.log('Connected to the MySQL database');
});

module.exports = connection;
