<?php
// signup.php - Trang đăng ký
session_start();
include "config.php";

// Xử lý đăng ký khi form được submit
if (isset($_POST['signup'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    
    // Kiểm tra xác nhận mật khẩu
    if ($password != $confirm_password) {
        $error = "Mật khẩu xác nhận không khớp!";
    } else {
        // Kiểm tra username hoặc email đã tồn tại chưa
        $check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
        $result = mysqli_query($conn, $check_query);
        $user = mysqli_fetch_assoc($result);
        
        if ($user) { 
            if ($user['username'] === $username) {
                $error = "Tên người dùng đã tồn tại!";
            }
            if ($user['email'] === $email) {
                $error = "Email đã được sử dụng!";
            }
        } else {
            // Mã hóa mật khẩu trước khi lưu vào database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Chèn người dùng mới vào database
            $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
            mysqli_query($conn, $query);
            
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Bạn đã đăng ký thành công";
            header('location: dashboard.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký tài khoản</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Đăng ký</h2>
            <form method="post" action="signup.php">
                <?php if(isset($error)) { ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php } ?>
                
                <div class="form-group">
                    <label>Tên người dùng</label>
                    <input type="text" name="username" required>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label>Xác nhận mật khẩu</label>
                    <input type="password" name="confirm_password" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" name="signup" class="btn">Đăng ký</button>
                </div>
                
                <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
            </form>
        </div>
    </div>
</body>
</html>