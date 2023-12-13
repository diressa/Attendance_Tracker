<?php
session_start();
$conn = new PDO("mysql:dbname=attendanceTracker;host=localhost;port=3307", 'root', 'root');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $professor_id = $_POST['professor_id'];
    $professor_name = $_POST['professor_name'];
    $professor_email = $_POST['professor_email'];

    // Insert the new professor into the database
    $stmt = $conn->prepare("INSERT INTO professor (professor_Name, professor_id, professor_email) VALUES (:professor_name, :professor_id, :professor_email)");
    $stmt->bindParam(":professor_name", $professor_name);
    $stmt->bindParam(":professor_id", $professor_id);
    $stmt->bindParam(":professor_email", $professor_email);
    $stmt->execute();

    header("Location: adminPage.php");
    exit();
} else {
    echo "Invalid request.";
}
?>