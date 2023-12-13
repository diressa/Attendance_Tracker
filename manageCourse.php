<html>
    <h3>Create a New Course</h3>
    <form action="createCourse.php" method="post">
        Course id: <input type="text" name="course_id" required>
        Course Name: <input type="text" name="course_name" required>
        <input type="submit" value="Create Course">
    </form>

    <h3>Assign Students and Professor to Course</h3>
    <form action="assignCourse.php" method="post">
        Course ID: <input type="text" name="course_id" required>
        Professor ID: <input type="text" name="professor_id" required>
        Student ID: <input type="text" name="student_ids" required>
        <input type="submit" value="Assign Course">
    </form>
</body>
</html>
