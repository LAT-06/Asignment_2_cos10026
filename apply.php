<?php
session_start();
include "setting.php";

// Nếu chưa đăng nhập và form được submit
if (!isset($_SESSION['username']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Lưu dữ liệu form vào session
    $_SESSION['form_data'] = $_POST;
    // Chuyển hướng đến trang login
    header("Location: login.php");
    exit();
}

// Lấy dữ liệu form đã lưu (nếu có)
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : array();

// Xóa dữ liệu form khỏi session nếu đã đăng nhập
if (isset($_SESSION['username']) && isset($_SESSION['form_data'])) {
    unset($_SESSION['form_data']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT web group AS1</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/style-apply.css">
</head>
<body>
    <header>
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
            <a href="jobs_add.php" class="admin-link admin-link-2">Add Jobs</a>
        <?php endif; ?>
        <div class="auth-buttons">
            <?php if(isset($_SESSION['username'])): ?>
                <a href="logout.php" class="btn">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn">Login</a>
                <a href="signup.php" class="btn">Sign up</a>
            <?php endif; ?>
        </div>
    </header>

    <header>
        <div class="title">
            <h1><strong>Application Form</strong></h1>
        </div>
    </header>

    <div class="form-container">               
        <?php if(isset($_SESSION['username'])): ?>
        <div>
            <form id="applyform" method="post" action="https://mercury.swin.edu.au/it000000/formtest.php">
                <div class="user-details">
                    <div class="input-box">
                        <label class="details" for="jobnum">Job Reference Number</label>
                        <input type="text" id="jobnum" name="jobnum" pattern="[a-zA-Z0-9]{5}" 
                               value="<?php echo isset($form_data['jobnum']) ? htmlspecialchars($form_data['jobnum']) : ''; ?>" required>
                    </div>
                    
                    <div class="input-box">
                        <label class="details" for="firstname">First Name</label>
                        <input type="text" id="firstname" name="firstname" maxlength="20" pattern="[a-zA-Z\s]{}"
                               value="<?php echo isset($form_data['firstname']) ? htmlspecialchars($form_data['firstname']) : ''; ?>" required>
                    </div>

                    <div class="input-box">
                        <label class="details" for="lastname">Last Name</label>
                        <input type="text" id="lastname" name="lastname" maxlength="20" pattern="[A-Za-z\s]{}"
                               value="<?php echo isset($form_data['lastname']) ? htmlspecialchars($form_data['lastname']) : ''; ?>" required>
                    </div>
        
                    <div class="input-box">
                        <label class="details" for="birthdate">Date of Birth</label><br>
                        <input type="date" id="birthdate" name="birthdate" 
                               value="<?php echo isset($form_data['birthdate']) ? htmlspecialchars($form_data['birthdate']) : ''; ?>" required>
                    </div>
        
                    <div class="input-box">
                        <fieldset class="gender-details">
                            <legend class="gender-title">Gender</legend>  
                            <div class="category">
                                <label class="gender" for="male">Male</label>
                                <input type="radio" id="male" name="gender" value="male"
                                       <?php echo (!isset($form_data['gender']) || $form_data['gender'] == 'male') ? 'checked' : ''; ?>>
                                <label class="gender" for="female">Female</label>  
                                <input type="radio" id="female" name="gender" value="female"
                                       <?php echo (isset($form_data['gender']) && $form_data['gender'] == 'female') ? 'checked' : ''; ?>>
                            </div>
                        </fieldset>
                    </div>
        
                    <div class="input-box">
                        <label class="details" for="strad">Street Address</label>
                        <input type="text" id="strad" name="str_add" maxlength="40"
                               value="<?php echo isset($form_data['str_add']) ? htmlspecialchars($form_data['str_add']) : ''; ?>" required>
                    </div>
        
                    <div class="input-box">
                        <label for="town">Suburb/Town</label>
                        <input type="text" id="town" name="town" maxlength="40"
                               value="<?php echo isset($form_data['town']) ? htmlspecialchars($form_data['town']) : ''; ?>" required>
                    </div>
        
                    <div class="input-box">
                        <label for="state">State</label>
                        <div>
                            <select name="state" id="state" required>
                                <option value="">Select your State</option>
                                <?php
                                $states = array('VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT');
                                foreach ($states as $state) {
                                    $selected = (isset($form_data['state']) && $form_data['state'] == $state) ? 'selected' : '';
                                    echo "<option value=\"$state\" $selected>$state</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
        
                    <div class="input-box">
                        <label for="postal">Postcode</label>
                        <div>
                            <input type="text" id="postal" name="postal" pattern="[0-9]{4}"
                                   value="<?php echo isset($form_data['postal']) ? htmlspecialchars($form_data['postal']) : ''; ?>" required>
                        </div>
                    </div>
        
                    <div class="input-box">
                        <label for="email">Email Address</label>
                        <div>
                            <input type="email" id="email" name="email"
                                   value="<?php echo isset($form_data['email']) ? htmlspecialchars($form_data['email']) : ''; ?>" required>
                        </div>
                    </div>
    
                    <div class="input-box">
                        <label for="phone">Phone Number</label>
                        <div>
                            <input type="text" id="phone" name="phone" pattern="[0-9\s]{8,12}"
                                   value="<?php echo isset($form_data['phone']) ? htmlspecialchars($form_data['phone']) : ''; ?>" required>
                        </div>
                    </div>
    
                    <div class="input-box">
                        <label><u>Skills</u></label>
                        <div class="skill-category">
                            <label for="technical">Technical</label>
                            <input type="checkbox" name="skill[]" id="technical" value="technical"
                                   <?php echo (isset($form_data['skill']) && in_array('technical', (array)$form_data['skill'])) ? 'checked' : ''; ?>>

                            <label for="soft">Soft</label>
                            <input type="checkbox" name="skill[]" id="soft" value="soft"
                                   <?php echo (isset($form_data['skill']) && in_array('soft', (array)$form_data['skill'])) ? 'checked' : ''; ?>>
                        
                            <label for="other">Other Skills...</label>
                            <input type="checkbox" name="skill[]" id="other" value="other"
                                   <?php echo (isset($form_data['skill']) && in_array('other', (array)$form_data['skill'])) ? 'checked' : ''; ?>>
                        </div>
                        <textarea placeholder="Other skills..." cols="42" rows="4" name="other"><?php echo isset($form_data['other']) ? htmlspecialchars($form_data['other']) : ''; ?></textarea>
                    </div>

                    <div class="button">
                        <input type="submit" value="Apply">
                    </div>
                </div>
            </form>
        </div>
        <?php else: ?>
            <div class="login-message">
                <p>Please <a href="login.php">login</a> to submit an application.</p>
            </div>
        <?php endif; ?>
    </div>
    <footer>
        <p>&copy; 2024 The Supreme Animal Quartet. All rights reserved.</p>
        <p>Contact us: <a href="mailto:group@example.com">group@example.com</a></p>
    </footer>
</body>
</html>