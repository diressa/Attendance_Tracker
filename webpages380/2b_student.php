<?php
require_once "config4.php";

//initialize variables to confirm credentials
$username = $password = $confirm_password = "";
//variables to deny access and produce an error
$username_err = $password_err = $confirm_password_err = "";

$sql = "SELECT student_id, student_Name, student_email, present, absence, absence_warning FROM student";

$_SERVER["REQUEST_METHOD"] == "POST"//to check connection on website: if(insert left statement){echo "It worked";}else{echo "It did not";}
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
	<form action="2b_student.php" method="post">
			<p>
				<label for="inputID">Student ID:<sup>*</sup></label>
        <input type="text" name="stu_id" id="inputID">
			</p>

			<!--<ol>
					<li><em>Your submission:</em>
					<?php //echo $_POST["stu_id"]?></li>
			</ol>-->

			<input type="submit" value="Submit">
		  <input type="reset" value="Reset">
	</form>

	<table style = "width = 100%;">
		<tr>
			<td>Student ID</td>
			<td>Name</td>
			<td>Email</td>
			<td>Present</td>
			<td>Absence</td>
			<td>Absence Warning</td>
		<tr>

		<tr>
		<?php
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while ($row = $result->fetch_assoc()) {
		        echo "<tr><td>" . $row["student_id"] . "</td>" .
								 "<td>" . $row["student_Name"] . "</td>" .
								 "<td>" . $row["student_email"] . "</td>" .
								 "<td>" . $row["present"] . "</td>" .
								 "<td>" . $row["absence"] . "</td>" .
								 "<td>" . $row["absence_warning"] . "</td></tr>";
		    }
			}?>
		</tr>
	</table>



</body>
</html>
<?php $conn->close(); //close connection ?>
