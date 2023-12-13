<html>
    <h3>Create new student</h3>
    <form action="createStudent.php" method="post">
        student id: <input type="text" name="student_id" required>
        student Name: <input type="text" name="student_name" required>
        student Email: <input type="text" name="student_email" required>
        <input type="submit" value="Create Student">
    </form>
    <h3>Create new professor</h3>
    <form action="createProfessor.php" method="post">
        professor id: <input type="text" name="professor_id" required>
        professor Name: <input type="text" name="professor_name" required>
        professor Email: <input type="text" name="professor_email" required>
        <input type="submit" value="Create professor">
    </form>
</body>
</html>
