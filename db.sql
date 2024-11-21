-- Create the database
CREATE DATABASE care_track;

-- Use the created database
USE care_track;

-- Table for storing admin users
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password CHAR(64) NOT NULL, -- SHA-256 hash is 64 characters
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for storing nurse users
CREATE TABLE nurses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password CHAR(64) NOT NULL, -- SHA-256 hash
    nurse_id VARCHAR(10) UNIQUE, -- Optional nurse ID (e.g., NUR001)
    name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE doctor_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
--Insert example admin user (hashed password for 'admin123')
INSERT INTO doctor_users (username, password) VALUES ('doctor', SHA2('doctor123', 256));

-- Insert example admin user (hashed password for 'admin123')
INSERT INTO admin_users (username, password, admin_id, name) VALUES ('admin', SHA2('admin123', 256),'ADM001', 'John');

-- Insert example nurse user (hashed password for 'nurse123')
INSERT INTO nurses (username, password, nurse_id, name) VALUES ('nurse1', SHA2('nurse123', 256), 'NUR001', 'Alice');

-- Insert example nurse user (hashed password for 'nurse123')
INSERT INTO nurses (username, password, nurse_id, name) VALUES ('nurse2', SHA2('nurse123', 256), 'NUR002', 'Bob');


-- Table for storing tasks
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    assigned_to VARCHAR(50) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    nurse_id VARCHAR(50),
    due_date DATE NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending'
);


CREATE TABLE IF NOT EXISTS patient_notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nurse_id VARCHAR(50),
    patient_name VARCHAR(255),
    note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE leave_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nurse_id VARCHAR(20) NOT NULL,
    from_date DATE NOT NULL,
    from_time TIME NOT NULL,
    to_date DATE NOT NULL,
    to_time TIME NOT NULL,
    reason TEXT NOT NULL,
    status ENUM('Pending', 'Approved', 'Denied') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE alternate_tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nurse_id VARCHAR(50) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    due_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


--added newly for admin
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password CHAR(64) NOT NULL,
    admin_id VARCHAR(10) UNIQUE, 
    name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Insert example admin user (hashed password for 'admin123')
INSERT INTO admin_users (username, password, admin_id, name) VALUES ('admin', SHA2('admin123', 256),'ADM001', 'John');