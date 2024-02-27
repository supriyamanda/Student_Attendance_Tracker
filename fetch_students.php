<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sitsatsat";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    // Fetch students taking the selected course
    $sql = "SELECT student_id FROM attendance_details WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $students = array();
    while($row = $result->fetch_assoc()) {
        $students[] = $row['student_id'];
    }

    // Return the list of students as JSON
    echo json_encode($students);
}

// Close the database connection
$conn->close();
?>
