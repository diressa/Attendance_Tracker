<?php
session_start();
$conn = new PDO("mysql:dbname=attendanceTracker;host=localhost;port=3307", 'root', 'root');

$professor_id = $_SESSION['professor_id']; // Retrieve professor ID from the session

// Fetch professor info
$stmt = $conn->prepare("SELECT professor_id, professor_Name FROM professor WHERE professor_id = :professor_id");
$stmt->bindParam(":professor_id", $professor_id);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $professor_id = $result['professor_id'];
    $professor_Name = $result['professor_Name'];
} else {
    echo "Professor not found.";
}

// Fetch attendance information for each enrolled course
$course_stmt = $conn->prepare("SELECT c.course_id, c.course_Name
                               FROM course c
                               JOIN enrollment_Info e ON c.course_id = e.course_id
                               LEFT JOIN professor p ON c.course_id = e.course_id AND p.professor_id = :professor_id
                               WHERE e.professor_id = :professor_id");
$course_stmt->bindParam(":professor_id", $professor_id);
$course_stmt->execute();
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style-admin.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/unit.css">
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <style type="text/css">*
        {cursor: url(attachments/cursor.GIF), auto !important;}
    </style>
    <script type="text/javascript" src="js/unit.js"></script>
    <title>Professor Dashboard</title>
</head>
<body onload="startTime()">
<div class="head">
    <h2>Welcome Back,
        <?php
        $professor_id = $_SESSION['professor_id']; // Change this based on your session variable

        $stmt = $conn->prepare("SELECT professor_Name FROM professor WHERE professor_id = :professor_id");
        $stmt->bindParam(":professor_id", $professor_id);
        $stmt->execute();

        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $professor_Name = $result['professor_Name'];
            echo "<span class='name'>$professor_Name</span>!";
        } else {
            echo "<span class='name'>Not Found</span>"; // Handle if professor not found
        }
        ?>
    </h2>
    <div class="head-right">
        <a href="homepage.php">Log out</a>
        <div id="head-time"></div>
    </div>
</div>
<div id="navigation">
    <nav role="navigation">
        <ul>
            <a href="professorPage.php"><li class="li-active">Home</li></a>
        </ul>
    </nav>
</div>
<div class="left">
    <span class="title-bar">Information</span><br/>
    <img src="images/touxiang.png" style="margin:10px 10px;">
    <div style="margin-left:30px;">
        <span class="name">
            <?php
            $professor_id = $_SESSION['professor_id']; // Change this based on your session variable

            $stmt = $conn->prepare("SELECT professor_Name FROM professor WHERE professor_id = :professor_id");
            $stmt->bindParam(":professor_id", $professor_id);
            $stmt->execute();

            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $professorName = $result['professor_Name'];
                echo "Name: <span class='name'>$professorName</span>";
            } else {
                echo "Name: <span class='name'>Not Found</span>"; // Handle if professor not found
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
                <th>Start class</th>
                <th>Absence Report</th>
                <th>Status Report</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($course_result = $course_stmt->fetch(PDO::FETCH_ASSOC)) {
                $course_id = $course_result['course_id'];
                $course_name = $course_result['course_Name'];
                ?>
                <tr>
                    <td><?php echo $course_id; ?></td>
                    <td><?php echo $course_name; ?></td>
                    <td>
                        <!-- Add a button to trigger the QR code generation -->
                        <button onclick="generateQRCode('<?php echo $course_id; ?>', '<?php echo $course_name; ?>')">Generate QR Code</button>
                        <!-- This is where the QR code will be displayed -->
                        <div id="qrcode_<?php echo $course_id; ?>"></div>
                    </td>
                    <td><a href="reportPage.php?course_id=<?php echo $course_id; ?>">Absence Status</a></td>
                    <td><a href="attendance_status.php?course_id=<?php echo $course_id; ?>">Generate Report</a></td>

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
                    this.Days[flag[i]].innerHTML = "<a href='javascript:void(0);' onclick=\"alert('Date:"+this.Year+"/"+this.Month+"/"+flag[i]+"');return false;\">" + flag[i] + "</a>";
                }
            }
        });

        $("idCalendarPre").onclick = function(){ cale.PreMonth(); }
        $("idCalendarNext").onclick = function(){ cale.NextMonth(); }

    </SCRIPT>

    <script language="JavaScript">
        function generateQRCode(courseId, courseName) {
            // Get the container element for the QR code
            var qrcodeContainer = document.getElementById('qrcode_' + courseId);

            // Clear any existing QR code
            qrcodeContainer.innerHTML = '';

            // Construct the QR code content (courseId, courseName, and a unique identifier)
            var qrCodeContent = courseId + '|' + courseName + '|' + generateUniqueIdentifier();

            // Create a new instance of QRCode
            var qrcode = new QRCode(qrcodeContainer, {
                text: qrCodeContent,
                width: 128,
                height: 128
            });
        }

        // Function to generate a unique identifier
        function generateUniqueIdentifier() {
            return Date.now().toString();
        }
    </script>
    <div style="width:100%;height:1px;" class="clear"></div>
</body>
</html>