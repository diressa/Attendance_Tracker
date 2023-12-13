<html>
<head>
    <title>HomePage</title>
    <style type="text/css">
        * {cursor: url(attachments/cursor.GIF), auto !important;}
        body {background-color: rgba(35, 47, 96, 1);}
    </style>
</head>


<body>

<h1 style ="
			text-align: center;
			font-family: Courier;
			font-size: 96px;
			font-weight: lighter;
			text-shadow: 2px 1px #444;
			color: rgb(220, 224, 244);


		">Attendance Tracker<br>
    <img src="attachments/notebook.GIF" width="100" height="100">

</h1>

<style>
    table{

        text-align: center;
        width: 100%;
    }
    tr:hover{
        background-color: rgba(220, 224, 244, 0.5);
        transition: 0.6s;
    }
    td{
        padding: 16px;
        text-align: center;
        border-top: 2px dotted #679;

        font-family: Courier;
        font-size: 36px;

        color: rgba(220, 224, 244, 0.8);
    }
</style>

<table>
    <tr onclick ="window.location.href='student.php';"><td>
            Student
        </td></tr>
    <tr onclick ="window.location.href='professor.php';"><td>
            Professor
        </td></tr>
    <tr onclick ="window.location.href='admin.php';"><td>
            Admin
        </td></tr>
</table>

</body>
</html>