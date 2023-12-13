<?php
session_start();
$conn = new PDO("mysql:dbname=attendanceTracker;host=localhost;port=3307", 'root', 'root');

if (isset($_POST['login'])) {
    $admin_id = $_POST['admin_id'];
    $admin_Name = $_POST['admin_Name'];
    $sql = "SELECT * FROM admin WHERE admin_id = '$admin_id' AND admin_Name ='$admin_Name'";
    $result = $conn->query($sql);

    if ($result->rowCount() == 0) {
        echo "Wrong password, Please try again";
    } else {
        $_SESSION['admin_id'] = $admin_id; // Set the session variable
        header('Location: adminPage.php');
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
        <form action="admin.php" method="post">
            <input type="text" class= "form_input" name="admin_Name" placeholder="Name"><br><br>
            <input type="password" class= "form_input" name="admin_id" placeholder="password"><br><br>

            <button type="submit" class = "form_button button submit" name="login">Login</button>
            <button type="submit" class = "form_button button submit" name="clear">Clear</button><br>
            <?php $_SESSION['admin_id'] = $admin_id; ?>
        </form>
    </div>

    </body>
    </html>
<?php $conn->close(); //close connection ?>