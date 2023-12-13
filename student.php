<?php
session_start();
$conn = new PDO("mysql:dbname=attendanceTracker;host=localhost;port=3307", 'root', 'root');

if (isset($_POST['login'])) {
    $student_id = $_POST['student_id'];
    $student_Name = $_POST['student_Name'];
    $sql = "SELECT * FROM student WHERE student_id = '$student_id' AND student_Name ='$student_Name'";
    $result = $conn->query($sql);

    if ($result->rowCount() == 0) {
        echo "Wrong password, Please try again";
    } else {
        $_SESSION['student_id'] = $student_id; // Set the session variable
        header('Location: studentPage.php');
    }
}
?>

    <html>
    <head>
        <title>Sign</title>
        <link rel="stylesheet" href="index.css">
        <style type="text/css">*
            {cursor: url(attachments/cursor.GIF), auto !important;}
        </style>
    </head>

    <body style= "text-align:center;">
    <!-- Button to go back to homepage -->
    <button onclick="window.location.href='homepage.php';"
            style="padding: 6px 8px;
		background-color: rgba(255,255,255, 0.4);
	">
        <p1 style="
			text-align: justify;
			font-family: Courier;
		">homepage</p1>
    </button><br>

    <!--Form to retrieve in php script*/ -->
    <div class="sign-container" id="Login">
        <h2 class="form_title title">Sign in</h2>
        <form action="student.php" method="post">
            <input type="text" class= "form_input" name="student_Name" placeholder="Name"><br><br>
            <input type="password" class= "form_input" name="student_id" placeholder="password"><br><br>

            <button type="submit" class = "form_button button submit" name="login">Login</button>
            <button type="submit" class = "form_button button submit" name="clear">Clear</button><br>
        <?php $_SESSION['student_id'] = $student_id; ?>
        </form>
    </div>

    </body>
    </html>
<?php $conn->close(); //close connection ?>