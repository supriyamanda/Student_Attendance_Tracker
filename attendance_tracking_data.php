<?php
session_start(); // Start the session
$studentId = $_SESSION['student_id']; // Assuming the session holds the student's ID after login

// Get the course ID from the URL query parameter
$courseId = $_GET['course_id']; // Adjust this to match your query parameter name

// Establish a connection to the database (using provided server details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sitsatsat";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute SQL query to fetch attendance data
$sql = "SELECT COUNT(*) AS total, 
        SUM(CASE WHEN attendance = 'Yes' THEN 1 ELSE 0 END) AS attended, 
        SUM(CASE WHEN attendance = 'No' THEN 1 ELSE 0 END) AS absent 
        FROM attendance_tracking 
        WHERE student_id = '$studentId' AND course_id = '$courseId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $attendanceData = $result->fetch_assoc();
    echo json_encode($attendanceData); // Send the attendance data as JSON
} else {
    echo json_encode(array('error' => 'No attendance data found for this student and course'));
}
$conn->close();
?>
