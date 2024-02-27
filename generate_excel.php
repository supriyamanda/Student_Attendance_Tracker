<?php
session_start(); // Start the session
$adminId = $_SESSION['admin_id'];

if (isset($_GET['course_id'])) {
    $courseId = $_GET['course_id'];

    // Establish a connection to the database 
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

    // Fetch required student details for the specific course from the database
    $sql = "SELECT sd.student_id, sd.firstname, sd.lastname, sd.email 
            FROM student_details sd
            JOIN attendance_details ad ON sd.student_id = ad.student_id
            WHERE ad.course_id = '$courseId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="student_attendance_details.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        // Write the headers to the CSV file
        fputcsv($output, array('Student ID', 'First Name', 'Last Name', 'Email', 'Classes Attended', 'Classes Absent'));

        // Loop through the query results and write them to the CSV file
        while ($row = $result->fetch_assoc()) {
            // Fetch attendance data for each student based on the course from the 'attendance_tracking' table
            $attendanceQuery = "SELECT COUNT(*) AS total, 
                                SUM(CASE WHEN attendance = 'Yes' THEN 1 ELSE 0 END) AS attended, 
                                SUM(CASE WHEN attendance = 'No' THEN 1 ELSE 0 END) AS absent 
                                FROM attendance_tracking 
                                WHERE student_id = '{$row['student_id']}' AND course_id = '$courseId'";
            $attendanceResult = $conn->query($attendanceQuery);
            $attendanceData = $attendanceResult->fetch_assoc();

            // Write student details and attendance data to the CSV file
            fputcsv($output, array(
                $row['student_id'],
                $row['firstname'],
                $row['lastname'],
                $row['email'],
                $attendanceData['attended'],
                $attendanceData['absent']
            ));
        }
        fclose($output);
    } else {
        echo "No data found for this course";
    }

    $conn->close();
} else {
    echo "No course ID provided";
}
?>
