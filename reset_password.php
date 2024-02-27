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

if(isset($_POST['userid'], $_POST['newpassword'], $_POST['usertype'])){
    $userid = $_POST['userid'];
    $newpassword = $_POST['newpassword'];
    $usertype = $_POST['usertype'];

    // Determine the table and ID field based on the user type
    $table = ($usertype === 'student') ? 'student_login_details' : 'admin_login_details';
    $idField = ($usertype === 'student') ? 'student_id' : 'admin_id';

    // Check if the user exists in the respective login details table
    $check_sql = "SELECT * FROM $table WHERE $idField = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Hash the new password
        $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);

        // Prepare and execute the update query
        $update_query = "UPDATE $table SET password = ? WHERE $idField = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ss", $hashed_password, $userid);
        
        if ($stmt->execute()) {
            // Password updated successfully
            echo "Password updated successfully!";
        } else {
            // Error updating password
            echo "Error updating password. Please try again.";
        }
    } else {
        // User does not exist in the respective login details table
        echo "User does not exist. Please check the ID and try again.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
