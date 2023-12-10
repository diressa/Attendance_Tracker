<?php
$servername = "localhost"; // MySQL server address
$username = "new_user"; // MySQL username
$password = ""; // MySQL password
$database = "attendanceTracker"; // MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

// Performing database operations below:

// Next line selects the first 2 columns of the 'student' table
$sql = "SELECT student_id, student_Name FROM student";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Column1: " . $row["student_id"] . " - Column2: " . $row["student_Name"] . "<br>";
    }
} else {
    echo "0 results";
}

// Close connection
//$conn->close();
?>




<!DOCTYPE html>
<head>
	<style>
		body{font: 20px Courier;}
	</style>
</head>

<body>
	<h1> Test </h1>
</body>
</html>
