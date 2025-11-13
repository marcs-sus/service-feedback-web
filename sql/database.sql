-- Database: feedback_system
-- SQL script used to create and initialize the database
--
-- Table for Sectors within the organization
CREATE TABLE
    sectors (
        sector_id SERIAL PRIMARY KEY,
        sector_name VARCHAR(100) NOT NULL,
        status BOOLEAN DEFAULT TRUE
    );

-- Table of Devices where the evaluations are submitted from
CREATE TABLE
    devices (
        device_id SERIAL PRIMARY KEY,
        device_name VARCHAR(100) NOT NULL,
        status BOOLEAN DEFAULT TRUE
    );

-- Table for Questions used in evaluations
CREATE TABLE
    questions (
        question_id SERIAL PRIMARY KEY,
        sector_id INT REFERENCES sectors (sector_id),
        question_text TEXT NOT NULL,
        scale_type INT DEFAULT 10,
        status BOOLEAN DEFAULT TRUE
    );

-- Table of Evaluations from public form
CREATE TABLE
    evaluations (
        evaluation_id SERIAL PRIMARY KEY,
        sector_id INT REFERENCES sectors (sector_id),
        question_id INT REFERENCES questions (question_id),
        device_id INT REFERENCES devices (device_id),
        response_score INT NOT NULL CHECK (response_score BETWEEN 0 AND 10),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- Table for Feedback from open-ended feedback field
CREATE TABLE
    feedback (
        feedback_id SERIAL PRIMARY KEY,
        sector_id INT REFERENCES sectors (sector_id),
        device_id INT REFERENCES devices (device_id),
        feedback_text TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- Table for Admin Users managing the system
CREATE TABLE
    admin_users (
        admin_id SERIAL PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password_hash TEXT NOT NULL
    );