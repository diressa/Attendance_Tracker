<?php require_once "config4.php";

//initialize variables to confirm credentials
$username = $password = $confirm_password = "";
//variables to deny access and produce an error
$username_err = $password_err = $confirm_password_err = "";

$sql = "SELECT student_id, student_Name FROM student";
$result = $conn->query($sql);



if($_SERVER["REQUEST_METHOD"] == "POST"){echo "It worked";}else{echo "It did not";}
?>

<html>
<head>
	<style type="text/css">*
	{cursor: url(attachments/cursor.GIF), auto !important;}
	table, th, td {border:1px solid black;}
</style>
</head>



<body style= "text-align:center;">
	<h2> Student ID: <?php echo ""; ?> </h2>

	<!-- Button to go back to homepage -->
	<button onclick="window.location.href='1_homepage.php';"
		style="padding: 6px 8px;
		background-color: rgba(255,255,255, 0.4);
	">
					<p1 style="
			text-align: center;
			font-family: Courier;
		">homepage</p1>
	</button><br>

	<!--Form to retrieve in php script*/ -->
	<form action="2_student.php" method="post">
			<p>
				<label for="inputID">Student ID:<sup>*</sup></label>
        <input type="text" name="stu_id" id="inputID">
			</p>

			<ol>
					<li><em>Your submission:</em>
					<?php echo $_POST["stu_id"]?></li>
			</ol>

			<input type="submit" value="Submit">
		  <input type="reset" value="Reset">
	</form>

	<table style = "width = 100%;">
		<tr><td>
		<?php
		if ($result->num_rows > 0) {
		    while ($row = $result->fetch_assoc()) {
		        echo "Column1: " . $row["student_id"] . "<br>";
		    }
			}?>
		</td></tr>

		<tr><td>
		<?php
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				while ($row = $result->fetch_assoc()){
					echo " - Column2: " . $row["student_Name"] . "<br>";
				}
			}
		?>
	</td></tr>
	</table>



</body>
</html>
<?php $conn->close(); //close connection ?>
