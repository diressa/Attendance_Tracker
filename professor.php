<?php
$conn = new PDO("mysql:dbname=attendanceTracker;host=localhost;port=3307", 'root', 'root');
$sql = "SELECT professor_id, professor_Name FROM professor";
session_start();

if (isset($_POST['login'])) {
    $professor_id = $_POST['professor_id'];
    $professor_Name = $_POST['professor_Name'];
    $sql = "SELECT * FROM professor WHERE professor_id = '$professor_id' AND professor_Name ='$professor_Name'";
    $result = $conn->query($sql);

    if ($result->rowCount() == 0) {
        echo "Wrong password, Please try again";
    } else {
        $_SESSION['professor_id'] = $professor_id; // Set the session variable
        header('Location: professorPage.php');
    }
}
?>

    <html>
    <head>
        <title>Sign</title>
        <link rel="stylesheet" href="index.css">
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
    <div class="sign-container" id="Login">
        <h2 class="form_title title">Sign in</h2>
        <form action="professor.php" method="post">
            <input type="text" class= "form_input" name="professor_Name" placeholder="Name"><br><br>
            <input type="password" class= "form_input" name="professor_id" placeholder="password"><br><br>

            <button type="submit" class = "form_button button submit" name="login">Login</button>
            <button type="submit" class = "form_button button submit" name="clear">Clear</button><br>
        </form>
    </div>
    </body>
    </html>
<?php $conn->close(); //close connection ?>