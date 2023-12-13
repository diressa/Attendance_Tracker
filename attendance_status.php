<?php
session_start();
$conn = new PDO("mysql:dbname=attendanceTracker;host=localhost;port=3307", 'root', 'root');

// Retrieve the course_id from the URL parameter
$course_id = $_GET['course_id'];

// Fetch students with more than five absences for the selected course
$report_stmt = $conn->prepare("SELECT s.student_id, s.student_Name, s.absence, s.present, a.attendance_id, a.timestamp
                               FROM student s
                               JOIN enrollment_info e ON s.student_id = e.student_id
                               LEFT JOIN attendance a ON s.student_id = a.student_id AND e.course_id = a.course_id
                               WHERE e.course_id = :course_id");
$report_stmt->bindParam(":course_id", $course_id);
$report_stmt->execute();
?>

<html>
<head>
    <title>Attendance Report</title>
</head>
<body>
<h2>Attendance Report for Course <?php echo $course_id; ?></h2>
<table border="1">
    <thead>
    <tr>
        <th>Student ID</th>
        <th>Student Name</th>
        <th>Present</th>
        <th>Absence</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($report_result = $report_stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $report_result['student_id'] . "</td>";
        echo "<td>" . $report_result['student_Name'] . "</td>";
        echo "<td>" . $report_result['present'] . "</td>";
        echo "<td>" . $report_result['absence'] . "</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

<table border="1">
    <thead>
    <tr>
        <th>Attendance Id</th>
        <th>Student Id</th>
        <th>Timestamp</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // Reset the pointer to the beginning of the result set
    $report_stmt->execute();

    while ($report_result = $report_stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $report_result['attendance_id'] . "</td>";
        echo "<td>" . $report_result['student_id'] . "</td>";
        echo "<td>" . $report_result['timestamp'] . "</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
</body>
</html>