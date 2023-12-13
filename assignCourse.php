<?php
session_start();
$conn = new PDO("mysql:dbname=attendanceTracker;host=localhost;port=3307", 'root', 'root');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'];
    $professor_id = $_POST['professor_id'];
    $student_ids = $_POST['student_ids'];

    // Assign professor to the course
    $stmt_professor = $conn->prepare("INSERT INTO enrollment_info (professor_id, course_id, role) VALUES (:professor_id, :course_id, 'teacher')");
    $stmt_professor->bindParam(":professor_id", $professor_id);
    $stmt_professor->bindParam(":course_id", $course_id);
    $stmt_professor->execute();

    // Assign students to the course
    $stmt_student = $conn->prepare("INSERT INTO enrollment_info (student_id, course_id, role) VALUES (:student_id, :course_id, 'student')");
    $stmt_student->bindParam(":course_id", $course_id);
    $stmt_student->bindParam(":student_id", $student_id);

    foreach ($student_ids as $student_id) {
        $stmt_student->execute();
    }

    header("Location: adminPage.php");
    exit();
} else {
    echo "Invalid request.";
}
?>