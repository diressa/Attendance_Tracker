<?php
session_start();
$conn = new PDO("mysql:dbname=attendanceTracker;host=localhost;port=3307", 'root', 'root');

// Get student and course ID from the session or any other source
$studentId = $_SESSION['student_id'];
$courseId = $_SESSION['course_id'];
$randomNumber = $_POST['random_number'];

// Check if the random number matches the stored value in the session
if ($_SESSION['random_number'] == $randomNumber) {
    // Clear the stored random number in the session to prevent reuse
    unset($_SESSION['random_number']);

    // Perform the necessary database operations
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Check if the attendance record already exists for the current session
        $stmtCheck = $conn->prepare("SELECT * FROM attendance WHERE student_id = :student_id AND course_id = :course_id");
        $stmtCheck->bindParam(":student_id", $studentId);
        $stmtCheck->bindParam(":course_id", $courseId);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() == 0) {
            // Insert attendance record into the database if it doesn't exist
            $attendance_id = $randomNumber;  // Use $randomNumber as attendance_id
            $stmtInsert = $conn->prepare("INSERT INTO attendance (attendance_id, student_id, course_id, timestamp) VALUES (:attendance_id, :student_id, :course_id, NOW())");
            $stmtInsert->bindParam(":attendance_id", $attendance_id);
            $stmtInsert->bindParam(":student_id", $studentId);
            $stmtInsert->bindParam(":course_id", $courseId);
            $stmtInsert->execute();

            // Update the 'present' field in the student table (assuming 'present' is the field to track attendance)
            $stmtUpdate = $conn->prepare("UPDATE student SET present = present + 1 WHERE student_id = :student_id");
            $stmtUpdate->bindParam(":student_id", $studentId);
            $stmtUpdate->execute();

            echo "Attendance recorded successfully";
        } else {
            echo "Attendance already recorded for this session.";
        }
    }catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid random number. Attendance not recorded.";
}
?>