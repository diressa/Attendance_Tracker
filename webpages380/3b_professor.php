<?php require_once "config4.php";

//Connect to the database
$sql = "SELECT student_id, student_Name, student_email, present, absence, absence_warning FROM student";

?>


<html>
<head>
	<style type="text/css">* {cursor: url(attachments/cursor.GIF), auto !important;}
					table, th, td {border:1px solid black;}
	</style>
</head>

<body style= "text-align:center;">
	<button onclick=
		"window.location.href='1_homepage.php';"
		style="padding: 6px 8px;
		background-color: rgba(255,255,255, 0.4);
	">
         	<p1 style="
			text-align: center;
			font-family: Courier;
		">homepage</p1>
	</button><br>

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
