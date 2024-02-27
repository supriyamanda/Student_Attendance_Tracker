<?php
// Database connection details
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

// Check if the course_id is received via GET request
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    // Query to fetch student IDs for the given course_id from the attendance_details table
    $sql = "SELECT student_id FROM attendance_details WHERE course_id = '$course_id'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $students = array();
        while ($row = $result->fetch_assoc()) {
            $students[] = $row['student_id'];
        }
        echo json_encode(['studentIds' => $students]); // Sending as an associative array with key 'studentIds'
    } else {
        echo json_encode(['error' => 'No students found for this course']);
    }
} else {
    echo json_encode(['error' => 'Course ID not provided']);
}

$conn->close();
?>
