<?php
session_start();
$conn = new PDO("mysql:dbname=attendanceTracker;host=localhost;port=3307", 'root', 'root');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $student_email = $_POST['student_email'];

    // Insert the new student into the database
    $stmt = $conn->prepare("INSERT INTO student (student_Name, student_id, student_email) VALUES (:student_name, :student_id, :student_email)");
    $stmt->bindParam(":student_name", $student_name);
    $stmt->bindParam(":student_id", $student_id);
    $stmt->bindParam(":student_email", $student_email);
    $stmt->execute();

    header("Location: adminPage.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
