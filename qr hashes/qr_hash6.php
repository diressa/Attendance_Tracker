<?php
$conn = new PDO("mysql:dbname=attendanceTracker;host=localhost;port=8080", 'new_user', '');

require_once "config4.php";
session_start();

if(isset($_POST['login'])){//click login button
    $student_id = $_POST['student_id'];
    $id_hash = $student_id % 10;

    $sql = "SELECT * FROM student WHERE student_id = '$student_id';
            UPDATE student SET present = present + 1 WHERE student_id = '$student_id';";


    if(($conn->multi_query($sql) == TRUE) && ($id_hash == 6)){
      //  login in successful (exists and correct qr code)
      do{
        if($result = $conn->store_result()){
          $result->free();
        }
      } while ($conn -> next_result());

        echo "You have been marked present, " . $student_id. ".<br> Return to homepage.";
    }else{
        echo "Invalid ID, Please try again or scan the correct QR Code";
    }
}

?>
<html>
<head>
	<style type="text/css">*
	{cursor: url(attachments/cursor.GIF), auto !important;}
	table, th, td {border:1px solid black;}
</style>
</head>



<body style= "text-align:center;">
	<!-- Button to go back to homepage -->
	<button onclick="window.location.href='homepage.php';"
		style="padding: 6px 8px;
		background-color: rgba(255,255,255, 0.4);
	">
			<p1 style="
			text-align: center;
			font-family: Courier;
		">homepage</p1>
	</button><br>

	<!--Form to retrieve in php script*/ -->
        <div id="Login">
            <h2>Attendance Roster: Mark yourself present</h2>
            <form action="" method="post">
                Enter your ID: <input type="text" name="student_id"><br><br>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
</body>
</html>
