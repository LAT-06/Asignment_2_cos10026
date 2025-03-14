<?php
// index.php - Trang chủ chính
session_start(); // Bắt đầu phiên
include "setting.php";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Web Group AS1</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header class="home_page">
        <nav>
            <a href="index.php" class="btn">Home</a>
            <a href="about.php" class="btn">About</a>
            <a href="jobs.php" class="btn">Job</a>
            <a href="apply.php" class="btn">Apply</a>
            <a href="enhancements.php" class="btn">Enhancement</a>
            <div class="line top"></div>
            <div class="line bottom"></div>
        </nav>
        <?php if (isset($_SESSION['username']) && $_SESSION['username'] == 'admin'): ?>
            <a href="manage.php" class="admin-link admin-link-1">Manage</a>
            <a href="jobs_manage.php" class="admin-link admin-link-2">Manage Jobs</a>
        <?php endif; ?>
        <div class="auth-buttons">
            <?php if(isset($_SESSION['username'])): ?>
                <a href="logout.php" class="btn">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn">Login</a>
                <a href="signup.php" class="btn">Sign up</a>
            <?php endif; ?>
        </div>
        <h1 id="slogan" class="animated-text">
            Where Technology Roars<br>
            <br>
            <span class="innovation"> Beyond Boundaries</span>
        </h1>
        <div class="frame">
            <a href="#learnmore" class="custom-btn btn-10">Learn more</a>
        </div>
        <div class="blur-container">
            <h1 class="blur-title">Transforming Businesses with Cutting-Edge Solutions</h1>
            <p class="blur-description">
                The Supreme Animal Quartet© is a leading technology company specializing in providing innovative software solutions and IT services.
            </p>
        </div>
    </header>
    
    <br><br><br>
    <!-- Section 1: Hình ảnh nhóm -->
    <section id="learnmore" class="team-section">
        <h2>Our Team</h2>
        <div class="team-image"></div>
    </section>
    
    <!-- Section 2: Thông tin doanh thu -->
    <section class="sales-info">
        <h2>In Number</h2>
        <div class="stat-number">
            <div class="stat-item" id="item1">
                <span class="stat-label">Years of Experience</span>
                <span class="stat-value">50+</span>
            </div>
            <div class="stat-item" id="item2">
                <span class="stat-label">Clients in Service</span>
                <span class="stat-value">100+</span>
            </div>
            <div class="stat-item" id="item3">
                <span class="stat-label">Increase in Productivity</span>
                <span class="stat-value">30%</span>
            </div>
        </div>
    </section>
    
    <footer>
        <p>© 2025 The Supreme Animal Quartet. All rights reserved.</p>
        <p>Contact us: <a href="mailto:group@example.com">group@example.com</a></p>
        <p><a href="https://youtu.be/uGOZ6yVv8lU">Introduction Video</a></p>
    </footer>
</body>
</html>