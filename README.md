# Student_Attendance_Tracker

## Overview

- This project aims to develop a comprehensive web-based attendance management system for educational institutions.
- The system facilitates efficient tracking of student attendance, course management, and reporting functionalities.

## Features

- User Authentication: Secure login system with hashed passwords and role-based access control.
- Course Management: Create, update, and delete courses with instructor details.
- Attendance Tracking: Record student attendance for each course session.
- Reporting: Generate attendance reports and visualizations for analysis.
- Enrollment: Manage student enrollment in courses.

## Technologies Used

- Frontend: HTML, CSS, JavaScript
- Backend: PHP
- Database: MySQL
- Web Server: Apache
- Development Tools: Visual Studio Code, XAMPP

## Setup Instructions

1. Clone the repository: `git clone https://github.com/supriyamanda/Student_Attendance_Tracker`
2. Set up the local development environment using XAMPP.
3. Create a database named "SitSatSat"
   - Admin Tables: admin_details, admin_login_details.
   - Student Tables: student_details, student_login_details.
   - Course Tables: course_information
   - Attendance Tables: attendance_details, attendance_tracking
4. Configure the database connection in the PHP files under the backend directory.
5. Start the Apache server and MySQL database.
6. Access the application via the web browser.

## Usage

- Navigate to the login page and authenticate using valid credentials.
- Upon successful login, access different modules such as course management, attendance tracking, and reporting.
- Perform operations such as adding courses, marking attendance, and generating reports as per your role permissions.
