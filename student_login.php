<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sitsatsat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_POST['student_id'];
$student_password = $_POST['student_password'];

$sql = "SELECT * FROM student_login_details WHERE student_id = '$student_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

    if (password_verify($student_password, $hashed_password)) {
        $_SESSION['student_id'] = $student_id;
        header("Location: student_dashboard.html");
        exit;
    }
}

echo "Invalid credentials. Please try again.";

$conn->close();
?>
