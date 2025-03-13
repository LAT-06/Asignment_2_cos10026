<?php
// login.php - Login page
session_start();
include "setting.php";

// Process login when form is submitted
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Check username
    $query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You have successfully logged in";
            header('location: dashboard.php');
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
}

// Guest login is handled in a separate form
if (isset($_POST['guest_login'])) {
    // Set guest session
    $_SESSION['username'] = 'guest';
    $_SESSION['is_guest'] = true;
    
    // Redirect directly to main page
    header('location: index.php'); // Change this to your main page name
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="styles/log_style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Login</h2>
            <!-- Regular login form -->
            <form method="post" action="login.php">
                <?php if(isset($error)) { ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php } ?>
                
                <div class="form-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" name="login" class="btn">Login</button>
                </div>
                
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
            </form>
            
            <div class="divider">
                <span>or</span>
            </div>
            
            <!-- Separate form for guest login -->
            <form method="post" action="login.php">
                <div class="form-group">
                    <button type="submit" name="guest_login" class="btn btn-guest">Continue as Guest</button>
                </div>
            </form>
            
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>
</body>
</html>