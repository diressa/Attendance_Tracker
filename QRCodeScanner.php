<?php
session_start();
$conn = new PDO("mysql:dbname=attendanceTracker;host=localhost;port=3307", 'root', 'root');

// Retrieve student ID for the current session
$student_id = $_SESSION['student_id'];
$course_id = $_SESSION['course_id'];

// Function to generate and store a random number in the session
function generateAndStoreRandomNumber() {
    $randomNumber = rand(1000, 9999);
    $_SESSION['random_number'] = $randomNumber;
    return $randomNumber;
}

// Call the function to generate and store the random number
$randomNumber = generateAndStoreRandomNumber();

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
                    console.log("Student ID: " + <?php echo json_encode($student_id); ?>);
                    console.log("Course ID: " + <?php echo json_encode($course_id); ?>);
                    console.log("Random Number: " + <?php echo json_encode($randomNumber); ?>);
                    console.log("URL Parameters: " + urlParams.toString());
                    alert("Attendance recorded successfully!");
                }
            };

            // Get the course_id from the URL parameter
            var urlParams = new URLSearchParams(window.location.search);
            var course_id = urlParams.get('course_id');

            // Get the course_id from the URL parameter
            var urlParams = new URLSearchParams(window.location.search);
            var course_id = urlParams.get('course_id');

            // Include the random number in the QR code content
            var random_number = <?php echo $randomNumber; ?>;
            xhr.send(`student_id=<?php echo json_encode($student_id); ?>&course_id=${course_id}&random_number=${random_number}`);
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