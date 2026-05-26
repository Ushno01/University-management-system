<?php
session_start();
include 'db.php';

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id    = trim($_POST['student_id']);
    $name   = trim($_POST['name']);
    $email  = trim($_POST['email']);
    $pass   = MD5($_POST['password']);

    // Check if student_id exists
    $check = mysqli_query($conn, "SELECT id FROM students WHERE student_id='$sid'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Student ID already registered!";
    } else {
        $sql = "INSERT INTO students (student_id, name, email, password) VALUES ('$sid','$name','$email','$pass')";
        if (mysqli_query($conn, $sql)) {
            $success = "Registration successful! You can now login.";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Student Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <strong>🎓 University Student Portal</strong>
    <div><a href="index.php">Home</a><a href="student_login.php">Login</a></div>
</div>

<div class="container">
    <h2>Student Registration</h2>
    <?php if($error) echo "<p class='error'>$error</p>"; ?>
    <?php if($success) echo "<p class='success'>$success</p>"; ?>

    <form method="POST">
        <label>Student ID</label>
        <input type="text" name="student_id" placeholder="e.g. STU2024001" required>

        <label>Full Name</label>
        <input type="text" name="name" placeholder="Your full name" required>

        <label>Gmail Address</label>
        <input type="email" name="email" placeholder="yourname@gmail.com">

        <label>Password</label>
        <input type="password" name="password" placeholder="Create a password" required>

        <button type="submit">Register</button>
    </form>
    <div class="link">Already registered? <a href="student_login.php">Login here</a></div>
</div>

</body>
</html>