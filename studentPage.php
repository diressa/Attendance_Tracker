<?php
session_start();
$conn = new PDO("mysql:dbname=attendanceTracker;host=localhost;port=3307", 'root', 'root');

$student_id = $_SESSION['student_id']; // Retrieve student ID from the session

//fetch student info
$stmt = $conn->prepare("SELECT student_id, student_Name FROM student WHERE student_id = :student_id");
$stmt->bindParam(":student_id", $student_id);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $student_id = $result['student_id'];
    $studentName = $result['student_Name'];
} else {
    echo "Student not found.";
}

// Fetch attendance information for each enrolled course
$course_stmt = $conn->prepare("SELECT c.course_id, c.course_Name, s.present, s.absence
                               FROM course c
                               JOIN enrollment_Info e ON c.course_id = e.course_id
                               LEFT JOIN student s ON c.course_id = e.course_id AND s.student_id = :student_id
                               WHERE e.student_id = :student_id");
$course_stmt->bindParam(":student_id", $student_id);
$course_stmt->execute();
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/unit.css">
    <link rel="stylesheet" type="text/css" href="css/style-personal.css">
    <style type="text/css">*
        {cursor: url(attachments/cursor.GIF), auto !important;}
    </style>
    <script type="text/javascript" src="js/unit.js">
    </script>
<title>Student Dashboard</title>
</head>
<body onload="startTime()">
    <div class="head">
    	<h2>Welcome back,
            <?php
            $student_id = $_SESSION['student_id']; // Change this based on your session variable

            $stmt = $conn->prepare("SELECT student_Name FROM student WHERE student_id = :student_id");
            $stmt->bindParam(":student_id", $student_id);
            $stmt->execute();

            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $studentName = $result['student_Name'];
                echo "<span class='name'>$studentName</span>!";
            } else {
                echo "Name: <span class='name'>Not Found</span>"; // Handle if student not found
            }
            ?>
        </h2>
    	<div class="head-right">
        	<a href="homepage.php">Log out</a>
			<div  id="head-time"></div>
    	</div>
    </div>
    <div id="navigation">
    	<nav role="navigation">
		  <ul>
		  	<a href="studentPage.php"><li class="li-active">Home</li></a>
		  </ul>
		</nav>
    </div>
    <div class="left">
    	<span class="title-bar">Information</span><br/>
    	<img src="images/user.png" style="margin:15px 20px;">
    	<div style="margin-left:40px;">
            <span class="name">
                <?php
                $student_id = $_SESSION['student_id']; // Change this based on your session variable

                $stmt = $conn->prepare("SELECT student_Name FROM student WHERE student_id = :student_id");
                $stmt->bindParam(":student_id", $student_id);
                $stmt->execute();

                // Fetch the result
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $studentName = $result['student_Name'];
                    echo "Name: <span class='name'>$studentName</span>";
                } else {
                    echo "Name: <span class='name'>Not Found</span>"; // Handle if student not found
                }
                ?>
            </span>
        </div>
		<div class="Calendar">
			<div id="idCalendarPre">&lt;&lt;</div>
			<div id="idCalendarNext">&gt;&gt;</div>
			<span id="idCalendarYear">2008</span> &nbsp; <span id="idCalendarMonth">8</span>
			<table cellspacing="0">
			  <thead>
				<tr>
				  <td>Sun</td>
				  <td>Mon</td>
				  <td>Tue</td>
				  <td>Wed</td>
				  <td>Thu</td>
				  <td>Fri</td>
				  <td>Sat</td>
				</tr>
			  </thead>
			  <tbody id="idCalendar">
			  </tbody>
			</table>
		  </div>
	</div>
    <div class="right">
    	<div class="right-main">
    		<span class="title-bar">Course</span><br/>
    		<table class="table table-striped" style="margin-left:40px; width:92%">
				<thead>
				   <tr>
					  <th>Course ID</th>
					  <th>Class Name</th>
					  <th>Attendance</th>
                      <th>Sign in</th>

				   </tr>
				</thead>
				<tbody>
                <?php
                    while ($course_result = $course_stmt->fetch(PDO::FETCH_ASSOC)) {
                        $course_id = $course_result['course_id'];
                        $course_name = $course_result['course_Name'];
                        $attendance = ($course_result['present'] ?? 0) . '/' . ($course_result['absence'] ?? 0);
                ?>
                 <tr>
                     <td><?php echo $course_id; ?></td>
                     <td><?php echo $course_name; ?></td>
                     <td><?php echo $attendance; ?></td>
                     <td><a href="QRCodeScanner.php?course_id=<?php echo $course_id; ?>">ScanQR</a></td>
                 </tr>
                 <?php
                    }
                 ?>
				</tbody>
			 </table>
    	</div>
<script language="JavaScript">

var cale = new Calendar("idCalendar", {
    SelectDay: new Date().setDate(10),
    onSelectDay: function(o){ o.className = "onSelect"; },
    onToday: function(o){ o.className = "onToday"; },
    onFinish: function(){
        $("idCalendarYear").innerHTML = this.Year; $("idCalendarMonth").innerHTML = this.Month;
        var flag = [10,15,20];
        for(var i = 0, len = flag.length; i < len; i++){
            this.Days[flag[i]].innerHTML = "<a href='javascript:void(0);' onclick=\"alert('Date::"+this.Year+"/"+this.Month+"/"+flag[i]+"');return false;\">" + flag[i] + "</a>";
        }
    }
});

$("idCalendarPre").onclick = function(){ cale.PreMonth(); }
$("idCalendarNext").onclick = function(){ cale.NextMonth(); }

</SCRIPT>
    	<div style="width:100%;height:1px;" class="clear"></div>
    	<hr/>
    	</div>
    </div>
</body>