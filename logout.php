<?php
session_start();
session_destroy();  // Hủy tất cả session
header("Location: index.php"); // Quay về trang chủ
exit();
?>