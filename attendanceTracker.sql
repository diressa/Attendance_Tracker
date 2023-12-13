CREATE DATABASE attendanceTracker;

USE attendanceTracker;

create table student(
    student_id      int				primary key,
    student_Name    varchar(50),
    student_email   varchar(100),
    present         int,
    absence         int,
    absence_warning Boolean
);
INSERT INTO student VALUES
(1249732, 'Hedy', 'hflore01@nyit.edu', 15, 5, NULL),
(1247836, 'Xiao', 'xmao20@nyit.edu', 17, 4, NULL);

create table professor(
    professor_id    int				primary key,
    professor_Name  varchar(50),
    professor_email varchar(100)
);
INSERT INTO professor VALUES
(1290019, 'Kristen', 'jzhuo01@nyit.edu');

create table admin(
    admin_id    int			primary key,
    admin_name  varchar(50),
    admin_email varchar(100)
);
INSERT INTO admin VALUES
(1234567, 'Beza', 'bnigatu@nyit.edu'),
(1345678, 'Keshawn', 'kmoses01@nyit.edu');

create table course(
    course_id   int				primary key,
    course_Name varchar(100)
);
INSERT INTO course VALUES
(380, 'Introduction to Software Engineering');

create table enrollment_info(
    student_id   int,
    professor_id int,
    course_id    int,
    admin_id     int,
	role         varchar(10),
    constraint adminFK
        foreign key (admin_id) references admin (admin_id),
    constraint courseFK
        foreign key (course_id) references course (course_id),
    constraint professorFK
        foreign key (professor_id) references professor (professor_id),
    constraint studentFK
        foreign key (student_id) references student (student_id)
);
INSERT INTO enrollment_Info VALUES
(1249732, NULL, 380, 1234567, 'student'),
(1247836, NULL, 380, 1234567, 'student'),
(NULL, 1290019, 380, 1234567, 'teacher');

create table attendance
(
    attendance_id int auto_increment primary key,
    student_id    int      null,
    course_id     int      null,
    timestamp     datetime null,
    constraint couseidAttendanceFK
        foreign key (course_id) references course (course_id),
    constraint studentAttendanceFK
        foreign key (student_id) references student (student_id)
);