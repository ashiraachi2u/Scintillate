# Scintillate

This is a chat application that allows users to communicate with each other. This project is built with Node.js and MySQL.

## Getting Started

### Prerequisites

Make sure you have the following installed on your system:

- [Node.js](https://nodejs.org/)
- [MySQL](https://www.mysql.com/)

### Installation

1. **Clone the repository**

   ```sh
   git clone https://github.com/ashiraachi2u/Scintillate.git
   cd Scintillate
  
2. **Create a .env file**

   Create a .env file in the root of the project and add your MySQL credentials.
   ```sh
     HOST=<your_mysql_host>
     USER=<your_mysql_user>
     PASSWORD=<your_mysql_password>
     DATABASE=<your_database_name>
   
3. **Set up the database**
   Create two tables in your MySQL database:
   ```sh
      CREATE TABLE chats (
    id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_id BIGINT NOT NULL,
    to_user_id BIGINT NOT NULL,
    message VARCHAR(1000)
   );

   CREATE TABLE users (
       id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
       created DATETIME DEFAULT CURRENT_TIMESTAMP,
       email VARCHAR(100) NOT NULL,
       username VARCHAR(255) NOT NULL,
       user_password VARCHAR(500) NOT NULL
   );
4. **Install dependencies**

   ```sh
   npm install

Running the Project

To run the project, use the following command:
   ```sh
npm start

    

