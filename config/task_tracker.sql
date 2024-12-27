-- Create Database
CREATE DATABASE IF NOT EXISTS task_tracker;
USE task_tracker;

-- Create Tasks Table
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    due_date DATE,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Optional: Insert some sample data
INSERT INTO tasks (title, description, priority, due_date, status) VALUES 
('Complete Project Proposal', 'Finish the detailed project proposal for the client', 'high', '2024-01-15', 'pending'),
('Team Meeting', 'Conduct weekly team sync-up meeting', 'medium', '2024-01-10', 'pending'),
('Update Documentation', 'Review and update project documentation', 'low', '2024-01-20', 'completed');
