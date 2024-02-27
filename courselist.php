<?php session_start();

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

$admin_id = $_SESSION['admin_id'];

// SQL query to retrieve courses taught by the admin
$sql = "SELECT course_id, coursename, instructorname,classlocation,instructorid FROM course_information";

$result = $conn->query($sql);

$courses = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

// Close the database connection
$conn->close();

$response = array(
    'courses' => $courses,
    'adminId' => $admin_id
);

// Return the courses as JSON
echo json_encode($response);
?>
