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

// Retrieve form data
$signup_user_type = $_POST['signup_user_type'];
$signup_student_id = $_POST['signup_student_id'];
$signup_username = $_POST['signup_username'];
$signup_password = $_POST['signup_password'];

// Check if student_id or admin_id exists
if ($signup_user_type === "student") {
    $check_sql = "SELECT student_id FROM student_details WHERE student_id = '$signup_student_id'";
} elseif ($signup_user_type === "admin") {
    $check_sql = "SELECT admin_id FROM admin_details WHERE admin_id = '$signup_student_id'";
} else {
    echo "Invalid user type.";
    exit;
}

$check_result = $conn->query($check_sql);

if ($check_result->num_rows == 1) {
    // Hash the password
    $hashed_password = password_hash($signup_password, PASSWORD_DEFAULT);

    // Insert data into the respective database table based on user type
    if ($signup_user_type === "student") {
        $sql = "INSERT INTO student_login_details (student_id, username, password) VALUES ('$signup_student_id', '$signup_username', '$hashed_password')";
    } elseif ($signup_user_type === "admin") {
        $sql = "INSERT INTO admin_login_details (admin_id, username, password) VALUES ('$signup_student_id', '$signup_username', '$hashed_password')";
    } else {
        echo "Invalid user type.";
        exit;
    }

    if ($conn->query($sql) === TRUE) {
        echo "Signup successful.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // The student_id or admin_id doesn't exist in the respective details table, so display an error message.
    echo "Invalid student ID or admin ID. Please use a valid ID.";
}

// Close the database connection
$conn->close();
?>
