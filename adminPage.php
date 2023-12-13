<?php
session_start();
$conn = new PDO("mysql:dbname=attendanceTracker;host=localhost;port=3307", 'root', 'root');
$admin_id = $_SESSION['admin_id'];
// Fetch admin info
$stmt = $conn->prepare("SELECT admin_id, admin_name FROM admin WHERE admin_id = :admin_id");
$stmt->bindParam(":admin_id", $admin_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if ($result) {
    $admin_id = $result['admin_id'];
    $admin_name = $result['admin_name'];
} else {
    echo "Admin not found.";
}

// Fetch all students
$stmt_students = $conn->prepare("SELECT student_id, student_Name, student_email FROM student");
$stmt_students->execute();
$students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);

// Fetch all teachers
$stmt_teachers = $conn->prepare("SELECT professor_id, professor_Name, professor_email FROM professor");
$stmt_teachers->execute();
$teachers = $stmt_teachers->fetchAll(PDO::FETCH_ASSOC);

// Fetch all courses
$stmt_courses = $conn->prepare("SELECT course_id, course_Name FROM course");
$stmt_courses->execute();
$courses = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);

//Fetch enrollment info
$stmt_enrollment = $conn->prepare("SELECT 
                                    CASE
                                        WHEN s.student_id IS NOT NULL THEN s.student_Name
                                        WHEN p.professor_id IS NOT NULL THEN p.professor_Name
                                        ELSE 'Unknown'
                                    END AS Name,
                                    c.course_id AS CourseID,
                                    c.course_Name AS Course,
                                    e.role
                                   FROM enrollment_Info e
                                   LEFT JOIN student s ON e.student_id = s.student_id
                                   LEFT JOIN professor p ON e.professor_id = p.professor_id
                                   JOIN course c ON e.course_id = c.course_id
                                   ORDER BY c.course_id");
$stmt_enrollment->execute();
$enrollments = $stmt_enrollment->fetchAll(PDO::FETCH_ASSOC);
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/style-admin.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/unit.css">
    <style type="text/css">*
        {cursor: url(attachments/cursor.GIF), auto !important;}
    </style>
    <script type="text/javascript" src="js/unit.js"></script>
    <title>Admin Dashboard</title>
</head>
<body onload="startTime()">
<div class="head">
    <h2>Welcome back,
        <?php
        $admin_id = $_SESSION['admin_id']; // Change this based on your session variable

        $stmt = $conn->prepare("SELECT admin_Name FROM admin WHERE admin_id = :admin_id");
        $stmt->bindParam(":admin_id", $admin_id);
        $stmt->execute();

        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $adminName = $result['admin_Name'];
            echo "<span class='name'>$adminName</span>!";
        } else {
            echo "Name: <span class='name'>Not Found</span>"; // Handle if admin not found
        }
        ?>
    </h2>
    <div class="head-right">
        <a href="homepage.php">Log out</a>
        <div id="head-time"></div>
    </div>
</div>
<!--link to home, manage course-->
<div id="navigation">
    <nav role="navigation">
        <ul>
            <a href="adminPage.php"><li class="li-active">Home</li></a>
            <a href="manageCourse.php"><li class="li-active">Manage Course</li></a>
            <a href="managePeople.php"><li class="li-active">Manage People</li></a>

        </ul>
    </nav>
</div>

<!--admin info-->
<div class="left">
    <span class="title-bar">Information</span><br/>
    <img src="images/touxiang.png" style="margin:10px 10px;">
    <div style="margin-left:30px;">
        <span class="name">
            <?php
            $admin_id = $_SESSION['admin_id']; // Change this based on your session variable

            $stmt = $conn->prepare("SELECT admin_Name FROM admin WHERE admin_id = :admin_id");
            $stmt->bindParam(":admin_id", $admin_id);
            $stmt->execute();

            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $adminName = $result['admin_Name'];
                echo "Name: <span class='name'>$adminName</span>";
            } else {
                echo "Name: <span class='name'>Not Found</span>"; // Handle if admin not found
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
<!--show all people in database-->
<div class="right">
    <div class="right-main">
        <span class="title-bar">Enrollment Information</span><br/>
        <table class="table table-striped" style="margin-left:40px; width:92%"> <?php
            $currentCourseID = null;
            foreach ($enrollments as $enrollment):
            if ($enrollment['CourseID'] !== $currentCourseID):
            // If a new course is encountered, start a new table
            if ($currentCourseID !== null): ?>
            </tbody>
        </table>
        <?php endif; ?>

        <!-- Create a new table for the current course -->
        <h4>Course: <?php echo $enrollment['Course']; ?></h4>
        <table class="table table-striped" style="margin-left:40px; width:92%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Role</th>
            </tr>
            </thead>
            <tbody>

            <?php
            $currentCourseID = $enrollment['CourseID'];
            endif;
            ?>
            <tr>
                <td><?php echo $enrollment['Name']; ?></td>
                <td><?php echo $enrollment['role']; ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <span class="title-bar">People</span><br/>
        <table class="table table-striped" style="margin-left:40px; width:92%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Role</th>
            </tr>
            <?php foreach ($enrollments as $enrollment): ?>
                <tr>
                    <td><?php echo $enrollment['Name']; ?></td>
                    <td><?php echo $enrollment['role']; ?></td>
                </tr>
            <?php endforeach; ?>
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
                    this.Days[flag[i]].innerHTML = "<a href='javascript:void(0);' onclick=\"alert('Date:"+this.Year+"/"+this.Month+"/"+flag[i]+"');return false;\">" + flag[i] + "</a>";
                }
            }
        });

        $("idCalendarPre").onclick = function(){ cale.PreMonth(); }
        $("idCalendarNext").onclick = function(){ cale.NextMonth(); }

    </SCRIPT>
    <div style="width:100%;height:1px;" class="clear"></div>
</body>
