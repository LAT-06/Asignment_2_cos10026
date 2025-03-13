<?php
session_start();

// Kiểm tra nếu không phải admin thì không cho vào trang manage.php
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Manage</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="apply.php">Apply</a>
        <a href="jobs.php">Jobs</a>
        <a href="logout.php">Logout</a>
    </nav>

    <h1>Admin Management Page</h1>
    <p>Welcome, Admin! Here you can manage the website.</p>
</body>
</html>
