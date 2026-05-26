<?php
session_start();
include 'db.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

$id  = $_SESSION['student_id'];
$res = mysqli_query($conn, "SELECT * FROM students WHERE id='$id'");
$student = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <strong>🎓 University Student Portal</strong>
    <div>
        Welcome, <?php echo $student['name']; ?> &nbsp;|&nbsp;
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="dashboard">
    <h2>Student Dashboard</h2>
    <br>

    <!-- Profile Info -->
    <div class="card">
               <h3>👤 My Profile</h3>
               <div class="info-box">
            <p><strong>Student ID:</strong> <?php echo $student['student_id']; ?></p>
            <p><strong>Name:</strong> <?php echo $student['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $student['email'] ?: 'Not set'; ?></p>
        </div>
    </div>

    <!-- Course -->
    <div class="card">
             <h3>📚 My Course</h3>
             <div class="info-box">
            <?php if ($student['course']): ?>
                <p><strong>Enrolled Course:</strong> <?php echo $student['course']; ?></p>
            <?php else: ?>
                <p>No course assigned yet. Please contact admin.</p>
            <?php endif; ?>
        </div>
        </div>

                <!-- Result -->
            <div class="card">
            <h3>📊 My Result</h3>
            <div class="info-box">
            <?php if ($student['result']): ?>
                <p><strong>Result / Grade:</strong> <?php echo $student['result']; ?></p>
            <?php else: ?>
                <p>Result not published yet.</p>
            <?php endif; ?>
            </div>
            </div>
</div>

</body>
</html>