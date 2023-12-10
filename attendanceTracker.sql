CREATE DATABASE attendanceTracker;

USE attendanceTracker;

CREATE TABLE attendance
(
    student_Id              INT          UNIQUE,
    student_Name            CHAR(30),
    course                  CHAR(30),
    attendance_status       CHAR(25),
    PRIMARY KEY (student_Id)
);

INSERT INTO course VALUES
(1702734, 'Ashley A', 'ITEC 310-M01', 'Present: 20 Late: 0 Absence: 0'),
(1237946, 'Bette B', 'CSCI 352-M01', 'Present: 20 Late: 0 Absence: 0'),
(1431686, 'Robert Cao', 'CSCI 385-M01', 'Present: 19 Late: 1 Absence: 0'),
(1278946, 'John C', 'CSCI 352-M01', 'Present: 17 Late: 0 Absence: 3'),
(1474873, 'Jack C', 'CSCI 352-M01', 'Present: 18 Late: 1 Absence: 1'),
(1363776, 'Shirley D', 'ITEC 310-M01', 'Present: 20 Late: 0 Absence:0 '),
(1164376, 'Dean D', 'CSCI 385-M01', 'Present: 18 Late: 0 Absence: 2'),
(1097966, 'Earl Gu', 'ITEC 310-M01', 'Present: 20 Late: 0 Absence: 0'),
(1245636, 'Kate G', 'ITEC 310-M01', 'Present: 19 Late: 1 Absence: 0'),
(1465673, 'Joyce Li', 'CSCI 352-M01', 'Present: 20 Late: 0 Absence: 0'),
(1264642, 'David Lu', 'CSCI 352-M01', 'Present: 20 Late: 0 Absence: 0'),
(1270392, 'Carl M', 'CSCI 352-M01', 'Present: 16 Late: 2 Absence: 2'),
(1213346, 'Ivy S', 'CSCI 385-M01', 'Present: 20 Late: 0 Absence: 0'),
(1013429, 'William Smith', 'CSCI 385-M01', 'Present: 15 Late: 0 Absence: 5'),
(1134498, 'Matthew T', 'CSCI 352-M01', 'Present: 20 Late: 0 Absence: 0'),
(1134290, 'Jenny V', 'ITEC 310-M01', 'Present: 15 Late: 0 Absence: 5'),
(1134873, 'Chris W', 'ITEC 310-M01', 'Present: 20 Late: 0 Absence: 0'),
(1249732, 'Nancy Y', 'CSCI 385-M01', 'Present: 17 Late: 3 Absence: 0'),
(1234783, 'Sophia Z', 'CSCI 352-M01', 'Present: 20 Late: 0 Absence: 0'),
(1247836, 'Tina Z', 'CSCI 385-M01', 'Present: 20 Late: 0 Absence: 0');

CREATE TABLE professor (
    professor_id 		INT 			PRIMARY KEY,
    professor_Name 		VARCHAR(50) 	NOT NULL,
    professor_email		VARCHAR(100)	NOT NULL
);
INSERT INTO professor VALUES
(1290019, 'Keshawn', 'kmoses01@nyit.edu');

CREATE TABLE admin (
    admin_id 			INT 			PRIMARY KEY,
    admin_name 			VARCHAR(50) 	NOT NULL,
    admin_email			VARCHAR(100)	NOT NULL
);
INSERT INTO admin VALUES
(1234567, 'Beza', 'bnigatu@nyit.edu'),
(1345678, 'Kristen', 'jzhuo01@nyit.edu');

CREATE TABLE course (
    course_id 		INT 			PRIMARY KEY,
    course_Name 	VARCHAR(100) 	NOT NULL
);
INSERT INTO course VALUES
(380, 'Introduction to Software Engineering');

CREATE TABLE enrollment_Info (
    student_id 		INT,
    professor_id 	INT,
    course_id		INT,
    role 			VARCHAR(10),
    FOREIGN KEY (student_id) REFERENCES student(student_id),
    FOREIGN KEY (professor_id) REFERENCES professor(professor_id),
    FOREIGN KEY (course_id) REFERENCES course(course_id)
);

INSERT INTO enrollment_Info VALUES
(1249732, NULL, 380, 'student'),
(1247836, NULL, 380, 'student'),
(NULL, 1290019, 380, 'teacher');
