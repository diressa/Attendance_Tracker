# Attendance Tracker
A website application that tracks the attendance of students through a QR-code login system. 
Professor and adminstator users have the ability to check a course's overall attendance report, generated from the updated 'attendanceTracker' database contents.

### Prereqs:
1. SQL: To store attendance and login information in a database (MySQL Server was used).
2. Apache Server: To be able to connect the frontend PHP/HTML pages to the database.
3. A web browser to run the application- which will also be able to open the PHP files. 

On a MacOS device, setting up the application environment may require:
1. Homebrew: To start the Apache Server in command line using 'brew services start httpd' .
MAMP or XAMPP will also work as managers to test or manage the web application.

### In-Person Events:
A professor is expected to generate 10 QR codes for students to scan on a projected screen. Each QR code links to a login page associated with the last digit of a student's ID to confirm their attendance for that day. Once students scan their assigned QR code, the professor can hide the projection to prevent students scanning twice for an absent classmate. If the professor wants to see their course's overall attendance, they can track that data on the report page.

### Flow:
If you were to open the program, there are a few expected 'flows' of webpages to follow based on the kind of user you are.

Admins:\
admin.php --> adminPage.php

Teachers:\
professor.php --> professorPage.php --> reportPage.php

Students:\
student.php --> studentPage.php --> QRCodeScanner.php --> qr_hash[last digit of student's ID number].php
