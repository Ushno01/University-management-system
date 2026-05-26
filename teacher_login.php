<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = trim($_POST['username']);
    $pass  = MD5($_POST['password']);

    $sql = "SELECT * FROM teachers WHERE username='$uname' AND password='$pass'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) == 1) {
        $teacher = mysqli_fetch_assoc($res);
        $_SESSION['teacher'] = $uname;
        $_SESSION['teacher_id'] = $teacher['id'];
        header("Location: teacher_dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Teacher Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <strong>🎓 University Student Portal</strong>
    <div><a href="index.php">Home</a></div>
</div>

<div class="container">
    <h2>Teacher Login</h2>
    <?php if($error) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" placeholder="Teacher username" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Teacher password" required>

        <button type="submit" style="background:#28a745;">Login as Teacher</button>
    </form>
    <div class="link"><a href="index.php">← Back to Home</a></div>
</div>

</body>
</html>
