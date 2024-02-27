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

// Check and validate the data received from attendancepage.html
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['students']) && isset($data['course_id']) && isset($data['date'])) {
    $course_id = $data['course_id'];
    $date = $data['date'];
    $students = $data['students'];

    foreach ($students as $student_id => $attendance_status) {
        // Here, $student_id should represent the student_id, not 0 or 1
        $sql = "INSERT INTO attendance_tracking (student_id, course_id, date, attendance) VALUES ('$student_id', '$course_id', '$date', '$attendance_status')";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            break; // Stop further processing on error
        }
    }
    echo "Attendance recorded successfully"; // Respond after loop execution
} else {
    echo "Invalid data received";
}

$conn->close();
?>
