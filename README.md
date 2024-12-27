# Task Tracker Web Application

## Overview
A modern, responsive Task Tracker web application built with PHP, MySQL, and Tailwind CSS. Features include task creation, editing, deletion, filtering, and dark mode support.

## Features
- Create, Read, Update, and Delete (CRUD) tasks
- Task filtering by status
- Responsive design with Tailwind CSS
- Dark mode toggle
- Priority and due date tracking

## Prerequisites
- PHP 7.4+
- MySQL 5.7+
- Web Server (Apache/Nginx)

## Setup Instructions
1. Clone the repository
2. Create MySQL database:
   ```sql
   CREATE DATABASE task_tracker;
   ```
3. Import the database schema:
   ```bash
   mysql -u root -p task_tracker < config/task_tracker.sql
   ```
4. Configure database connection in `config/database.php`
5. Start your web server and navigate to `public/index.html`

## Database Configuration
- Host: localhost
- Port: 3307
- Database: task_tracker
- Username: root
- Password: (empty by default)

## Technologies
- Backend: PHP
- Frontend: HTML, JavaScript, Tailwind CSS
- Database: MySQL

## License
MIT License

## Contact
- **Name**: Jan Harry Madrona
- **Email**: xtremejeel@gmail.com
- **GitHub**: [github.com/janharrymadrona](https://https://github.com/zynxoso)
