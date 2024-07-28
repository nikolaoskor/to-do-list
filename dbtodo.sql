CREATE DATABASE IF NOT EXISTS dbtodo;
USE dbtodo;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    gender ENUM('male','female') NOT NULL,
    profile_picture VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    description TEXT NOT NULL,
    type ENUM('note', 'to-do') NOT NULL, 
    urgency ENUM('normal', 'urgent') DEFAULT 'normal',
    status ENUM('in_progress', 'done') DEFAULT 'in_progress',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Data entry in the users table
INSERT INTO users (name, email, password, gender, profile_picture) VALUES
('Nikos', 'nikos@example.com', 'password1', 'male', 'male.png'),
('Maria', 'maria@example.com', 'password2', 'female','female.png' );


-- Data entry into the pending tasks table
INSERT INTO tasks (user_id, description, type, urgency, status) VALUES
(1, 'Do something important', 'note', 'urgent', 'in_progress'),
(1, 'Document storage', 'to-do', 'normal', 'done'),
(2, 'Meeting with a client', 'to-do', 'urgent', 'in_progress');