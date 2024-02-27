<?php
session_start(); // Start the session
$studentId = $_SESSION['student_id'];

// Establish a connection to the database
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

// Fetch enrolled courses for the logged-in student from attendance_details table
$sql = "SELECT DISTINCT course_id FROM attendance_details WHERE student_id = '$studentId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $courses = array();
    while ($row = $result->fetch_assoc()) {
        // Fetch course details from course_information table based on the course_id
        $courseId = $row['course_id'];
        $courseInfoQuery = "SELECT course_id, coursename FROM course_information WHERE course_id = '$courseId'";
        $courseInfoResult = $conn->query($courseInfoQuery);
        $courseInfo = $courseInfoResult->fetch_assoc();
        $courses[] = $courseInfo;
    }
    echo json_encode($courses); // Send the enrolled courses' data as JSON
} else {
    echo "No enrolled courses found for this student";
}
$conn->close();
?>
