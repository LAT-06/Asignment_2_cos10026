<?php
// config.php - Cấu hình kết nối database
$host = "feenix-mariadb-web.swin.edu.au";
$user = "s105544477"; // Sử dụng username bạn đã cung cấp
$pwd = "Khanh105544477"; // Sử dụng password bạn đã cung cấp
$sql_db = "s105544477_db"; // Sử dụng database bạn đã cung cấp

// Tạo kết nối
$conn = mysqli_connect($host, $user, $pwd, $sql_db);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
?>