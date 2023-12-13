<?php
session_start();
$conn = new PDO("mysql:dbname=attendanceTracker;host=localhost;port=3307", 'root', 'root');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];

    // Insert the new course into the database
    $stmt = $conn->prepare("INSERT INTO course (course_Name, course_id) VALUES (:course_name, :course_id)");
    $stmt->bindParam(":course_name", $course_name);
    $stmt->bindParam(":course_id", $course_id);
    $stmt->execute();

    header("Location: adminPage.php");
    exit();
} else {
    echo "Invalid request.";
}
?>