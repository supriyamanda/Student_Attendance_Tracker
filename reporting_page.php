<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporting Page</title>
    <link rel="stylesheet" href="reporting_styles.css">
</head>
<body>
    <div class="content">
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

        $adminId = $_SESSION['admin_id'];

        $sql = "SELECT * FROM course_information WHERE instructorid = '$adminId'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<a href='generate_excel.php?course_id={$row['course_id']}' style='font-size: 18px; font-weight: bold;'>{$row['coursename']}</a><br>";
            }
        } else {
            echo "No courses assigned.";
        }

        $conn->close();
        ?>
    </div>

    <div class="gif-container">
        <img src="gif1.gif" alt="GIF 1">
    </div>

    <!-- Add canvas element for histogram -->
    <canvas id="attendanceHistogram" width="20px" height="20px"></canvas>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Fetch and display histogram data -->
    <script src="fetch_histogram_data.js"></script>
</body>
</html>

