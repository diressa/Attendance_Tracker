<?php
session_start();
$conn = new PDO("mysql:dbname=attendanceTracker;host=localhost;port=3307", 'root', 'root');

// Get student and course ID from the session or any other source
$studentId = $_SESSION['student_id'];
$courseId = $_POST['course_id'];  // Updated to get course_id from the POST data

// Check if the attendance record already exists
$stmtCheck = $conn->prepare("SELECT * FROM attendance WHERE student_id = :student_id AND course_id = :course_id");
$stmtCheck->bindParam(":student_id", $studentId);
$stmtCheck->bindParam(":course_id", $courseId);
$stmtCheck->execute();

if ($stmtCheck->rowCount() == 0) {
    // Insert attendance record into the database if it doesn't exist
    $stmtInsert = $conn->prepare("INSERT INTO attendance (student_id, course_id, timestamp) VALUES (:student_id, :course_id, NOW())");
    $stmtInsert->bindParam(":student_id", $studentId);
    $stmtInsert->bindParam(":course_id", $courseId);
    $stmtInsert->execute();

    // Update the 'present' field in the student table (assuming 'present' is the field to track attendance)
    $stmtUpdate = $conn->prepare("UPDATE student SET present = present + 1 WHERE student_id = :student_id");
    $stmtUpdate->bindParam(":student_id", $studentId);
    $stmtUpdate->execute();

    echo "Attendance recorded successfully!";
} else {
    echo "Attendance already recorded for this session.";
}
?>
