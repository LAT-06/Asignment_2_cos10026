<?php
// logout.php - Trang đăng xuất
session_start();
session_destroy();
header('location: login.php');
exit();
?>