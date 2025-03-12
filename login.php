<?php
// login.php - Trang đăng nhập
session_start();
include "setting.php";

// Xử lý đăng nhập khi form được submit
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Kiểm tra username
    $query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Xác minh mật khẩu
        if (password_verify($password, $user['password'])) {
            // Mật khẩu chính xác
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Bạn đã đăng nhập thành công";
            header('location: dashboard.php');
            exit();
        } else {
            $error = "Tên đăng nhập hoặc mật khẩu không chính xác";
        }
    } else {
        $error = "Tên đăng nhập hoặc mật khẩu không chính xác";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <link rel="stylesheet" type="text/css" href="styles/log_style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Đăng nhập</h2>
            <form method="post" action="login.php">
                <?php if(isset($error)) { ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php } ?>
                
                <div class="form-group">
                    <label>Tên người dùng</label>
                    <input type="text" name="username" required>
                </div>
                
                <div class="form-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" name="login" class="btn">Đăng nhập</button>
                </div>
                
                <p>Chưa có tài khoản? <a href="signup.php">Đăng ký</a></p>
            </form>
        </div>
    </div>
</body>
</html>