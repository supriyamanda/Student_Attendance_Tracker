<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sitsatsat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$adminId = $_SESSION['admin_id'];

// Fetch courses assigned to the admin
$sql = "SELECT * FROM course_information WHERE instructorid = '$adminId'";
$result = $conn->query($sql);

$attendedTotal = 0;
$absentTotal = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courseId = $row['course_id'];

        // Fetch attendance data for each course
        $attendanceQuery = "SELECT COUNT(*) AS total, SUM(CASE WHEN attendance = 'Yes' THEN 1 ELSE 0 END) AS attended, SUM(CASE WHEN attendance = 'No' THEN 1 ELSE 0 END) AS absent FROM attendance_tracking WHERE course_id = '$courseId'";
        $attendanceResult = $conn->query($attendanceQuery);
        $attendanceData = $attendanceResult->fetch_assoc();

        // Aggregate the attendance data for all courses
        $attendedTotal += $attendanceData['attended'];
        $absentTotal += $attendanceData['absent'];
    }
}

// Close the database connection
$conn->close();

// Prepare and output the attendance summary as JSON
$attendanceSummary = [
    'attended' => $attendedTotal,
    'absent' => $absentTotal
];

header('Content-Type: application/json');
echo json_encode($attendanceSummary);
?>