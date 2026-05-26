<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sid  = trim($_POST['student_id']);
    $pass = MD5($_POST['password']);

    $sql = "SELECT * FROM students WHERE student_id='$sid' AND password='$pass'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) == 1) {
        $student = mysqli_fetch_assoc($res);
        $_SESSION['student_id'] = $student['id'];
        $_SESSION['student_name'] = $student['name'];
        header("Location: student_dashboard.php");
        exit();
    } else {
        $error = "Invalid Student ID or Password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <strong>🎓 University Student Portal</strong>
    <div><a href="index.php">Home</a><a href="register.php">Register</a></div>
</div>

<div class="container">
    <h2>Student Login</h2>
    <?php if($error) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <label>Student ID</label>
        <input type="text" name="student_id" placeholder="Enter your Student ID" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter your password" required>

        <button type="submit">Login</button>
    </form>
    <div class="link">New student? <a href="register.php">Register here</a></div>
</div>

</body>
</html>