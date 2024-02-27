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

// Check if the studentid is received via GET request
if (isset($_GET['studentid'])) {
    $studentid = $_GET['studentid'];

    // Query to fetch student details based on the received studentid
    $sql = "SELECT * FROM student_details WHERE student_id = '$studentid'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $studentData = $result->fetch_assoc();
        echo json_encode($studentData);
    } else {
        echo json_encode(['error' => 'Student not found']);
    }
} else {
    echo json_encode(['error' => 'Student ID not provided']);
}

$conn->close();
?>
