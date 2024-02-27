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

// Assuming the admin ID is retrieved from the session after login
$adminId = $_SESSION['admin_id'];

// Fetching histogram data
$histogramData = array();

$sql = "SELECT course_id, COUNT(CASE WHEN attendance = 'Yes' THEN 1 ELSE NULL END) AS attended,
               COUNT(CASE WHEN attendance = 'No' THEN 1 ELSE NULL END) AS absent
        FROM attendance_tracking
        WHERE course_id IN (SELECT course_id FROM course_information WHERE instructorid = '$adminId')
        GROUP BY course_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $histogramData[] = $row;
    }
}

$conn->close();

// Return histogram data as JSON
header('Content-Type: application/json');
echo json_encode($histogramData);
?>
