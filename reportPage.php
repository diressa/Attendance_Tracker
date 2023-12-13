<?php
session_start();
$conn = new PDO("mysql:dbname=attendanceTracker;host=localhost;port=3307", 'root', 'root');

// Retrieve the course_id from the URL parameter
$course_id = $_GET['course_id'];

// Fetch students with more than five absences for the selected course
$report_stmt = $conn->prepare("SELECT s.student_id, s.student_Name, s.absence
                               FROM student s
                               JOIN enrollment_info e ON s.student_id = e.student_id
                               WHERE e.course_id = :course_id AND s.absence >= 5");
$report_stmt->bindParam(":course_id", $course_id);
$report_stmt->execute();
?>

<html>
<head>
    <title>Attendance Report</title>
    <!-- Add your CSS and other head elements here -->
</head>
<body>
<h2>Attendance Report for Course <?php echo $course_id; ?></h2>
<table border="1">
    <thead>
    <tr>
        <th>Student ID</th>
        <th>Student Name</th>
        <th>Absence Count</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($report_result = $report_stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $report_result['student_id'] . "</td>";
        echo "<td>" . $report_result['student_Name'] . "</td>";
        echo "<td>" . $report_result['absence'] . "</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
</body>
</html>