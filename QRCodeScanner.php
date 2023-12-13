<?php
session_start();
$conn = new PDO("mysql:dbname=attendanceTracker;host=localhost;port=3307", 'root', 'root');
$admin_id = $_SESSION['admin_id'];

// ... (your existing code fetching admin information)

// Retrieve student ID for the current session
$student_id = $_SESSION['student_id'];

// Fetch all students
$stmt_students = $conn->prepare("SELECT student_id, student_Name, student_email FROM student");
$stmt_students->execute();
$students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);

// Fetch all teachers
$stmt_teachers = $conn->prepare("SELECT professor_id, professor_Name, professor_email FROM professor");
$stmt_teachers->execute();
$teachers = $stmt_teachers->fetchAll(PDO::FETCH_ASSOC);

// Fetch all courses
$stmt_courses = $conn->prepare("SELECT course_id, course_Name FROM course");
$stmt_courses->execute();
$courses = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);

// Fetch enrollment info
$stmt_enrollment = $conn->prepare("SELECT 
                                    CASE
                                        WHEN s.student_id IS NOT NULL THEN s.student_Name
                                        WHEN p.professor_id IS NOT NULL THEN p.professor_Name
                                        ELSE 'Unknown'
                                    END AS Name,
                                    c.course_id AS CourseID,
                                    c.course_Name AS Course,
                                    e.role
                                   FROM enrollment_Info e
                                   LEFT JOIN student s ON e.student_id = s.student_id
                                   LEFT JOIN professor p ON e.professor_id = p.professor_id
                                   JOIN course c ON e.course_id = c.course_id
                                   ORDER BY c.course_id");
$stmt_enrollment->execute();
$enrollments = $stmt_enrollment->fetchAll(PDO::FETCH_ASSOC);
?>

<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>QR Code Scanner / Reader</title>
</head>

<body>
<div class="container">
    <h1>Scan QR Codes</h1>
    <div class="section">
        <div id="my-qr-reader"></div>
    </div>
</div>
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="script.js"></script>
<script>
    function domReady(fn) {
        if (
            document.readyState === "complete" ||
            document.readyState === "interactive"
        ) {
            setTimeout(fn, 1000);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }
    domReady(function () {
        function onScanSuccess(decodeText, decodeResult) {
            // Parse the QR code content
            var qrCodeContent = decodeText.split('|');

            // Extract course information
            var courseId = qrCodeContent[0];
            var courseName = qrCodeContent[1];

            // Send the scanned QR data to the server
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "processAttendance.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert("Attendance recorded successfully!");
                }
            };
            xhr.send(`student_id=${<?php echo json_encode($student_id); ?>}&course_id=${course_id}`);
        }

        let htmlscanner = new Html5QrcodeScanner(
            "my-qr-reader",
            { fps: 10, qrbos: 250 }
        );
        htmlscanner.render(onScanSuccess);
    });
</script>
</body>

</html>