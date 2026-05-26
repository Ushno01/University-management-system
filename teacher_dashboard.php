<?php
session_start();
include 'db.php';

if (!isset($_SESSION['teacher'])) {
    header("Location: teacher_login.php");
    exit();
}

$msg = "";

// Update Result Only
if (isset($_POST['update_result'])) {
    $id     = intval($_POST['id']);
    $result = trim($_POST['result']);

    mysqli_query($conn, "UPDATE students SET result='$result' WHERE id='$id'");
    $msg = "<p class='success'>Result updated successfully!</p>";
}

// Fetch student to edit (result only)
$edit_student = null;
if (isset($_GET['edit'])) {
    $eid = intval($_GET['edit']);
    $er  = mysqli_query($conn, "SELECT * FROM students WHERE id='$eid'");
    $edit_student = mysqli_fetch_assoc($er);
}

// All students
$all = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .teacher-badge {
            display: inline-block;
            background: #28a745;
            color: white;
            font-size: 12px;
            padding: 2px 8px;
            border-radius: 10px;
            margin-left: 8px;
            vertical-align: middle;
        }
        .btn-result {
            background: #28a745;
        }
        .btn-result:hover {
            background: #218838;
        }
        .notice-box {
            background: #fff3cd;
            border-left: 4px solid #f0a500;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>

<div class="navbar" style="background:#1a6b2e;">
    <strong>🎓 University Student Portal — <span style="font-weight:normal;">Teacher Panel</span></strong>
    <div>
        Welcome, <?php echo $_SESSION['teacher']; ?> <span class="teacher-badge">Teacher</span>
        &nbsp;|&nbsp;
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="dashboard">
    <h2>Teacher Dashboard</h2>
    <?php echo $msg; ?>

    <div class="notice-box">
        📌 <strong>Teacher Access:</strong> You can view all student records and update student results/grades only. To make other changes, please contact the admin.
    </div>

    <!-- Edit Result Form -->
    <?php if ($edit_student): ?>
    <div class="card">
        <h3>✏️ Update Result for: <strong><?php echo htmlspecialchars($edit_student['name']); ?></strong> (<?php echo htmlspecialchars($edit_student['student_id']); ?>)</h3>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $edit_student['id']; ?>">

            <div class="form-row">
                <div style="flex:1">
                    <label>Student</label>
                    <input type="text" value="<?php echo htmlspecialchars($edit_student['name']); ?>" disabled style="background:#f5f5f5;">
                </div>
                <div style="flex:1">
                    <label>Course</label>
                    <input type="text" value="<?php echo htmlspecialchars($edit_student['course'] ?: 'Not assigned'); ?>" disabled style="background:#f5f5f5;">
                </div>
            </div>

            <div class="form-row">
                <div style="flex:1">
                    <label>Result / Grade <span style="color:#28a745;">(Editable)</span></label>
                    <input type="text" name="result" placeholder="e.g. A+, Pass, 3.8 GPA"
                           value="<?php echo htmlspecialchars($edit_student['result'] ?? ''); ?>" required>
                </div>
            </div>

            <button type="submit" name="update_result" style="background:#28a745; width:auto; padding:10px 24px;">
                💾 Save Result
            </button>
            &nbsp;
            <a href="teacher_dashboard.php" class="btn" style="background:#888; width:auto; display:inline-block; padding:10px 20px;">Cancel</a>
        </form>
    </div>
    <?php endif; ?>

    <!-- Students Table -->
    <div class="card">
        <h3>📋 All Students</h3>
        <table>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Result / Grade</th>
                <th>Update Result</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($all)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['course'] ?: '—'); ?></td>
                <td>
                    <?php if ($row['result']): ?>
                        <span style="font-weight:bold; color:#1a6b2e;"><?php echo htmlspecialchars($row['result']); ?></span>
                    <?php else: ?>
                        <span style="color:#aaa;">Not set</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="?edit=<?php echo $row['id']; ?>" class="btn-small btn-result">Edit Result</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

</body>
</html>
