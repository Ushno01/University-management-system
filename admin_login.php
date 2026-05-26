<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = trim($_POST['username']);
    $pass  = MD5($_POST['password']);

    $sql = "SELECT * FROM admins WHERE username='$uname' AND password='$pass'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) == 1) {
        $_SESSION['admin'] = $uname;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <strong>🎓 University Student Portal</strong>
    <div><a href="index.php">Home</a></div>
</div>

<div class="container">
    <h2>Admin Login</h2>
    <?php if($error) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" placeholder="Admin username" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Admin password" required>

        <button type="submit">Login</button>
    </form>
    <div class="link">Default: admin / admin123</div>
</div>

</body>
</html>