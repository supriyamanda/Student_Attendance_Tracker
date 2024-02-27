<?php
session_start();
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
$admin_id = $_POST['admin_id'];
$admin_password = $_POST['admin_password'];

// SQL query to check admin login credentials
$sql = "SELECT * FROM admin_login_details WHERE admin_id = '$admin_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

    if (password_verify($admin_password, $hashed_password)) {
        // Valid login credentials for admin
        $_SESSION['admin_id'] = $admin_id;
        // Redirect to the secondpage.html
        header("Location: secondpage.html");
        exit;
    }
}

// Invalid login credentials for admin
echo "Invalid admin credentials. Please try again.";

// Close the database connection
$conn->close();
?>
