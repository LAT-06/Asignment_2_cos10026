<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        session_start();
        // Redirect if accessed directly
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            header("Location: error.php?error=unauthorized");
            exit();
        }

        require_once "setting.php";
        $conn = mysqli_connect ($host, $user, $pwd, $sql_db);

        // Check connection
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }   

        // Ensure the EOI table exists
        $table_sql = "CREATE TABLE IF NOT EXISTS eoi (
        eoi_id INT AUTO_INCREMENT PRIMARY KEY,
        job_ref CHAR(5) NOT NULL,
        first_name VARCHAR(20) NOT NULL,
        last_name VARCHAR(20) NOT NULL,
        dob DATE NOT NULL,
        gender ENUM('Male', 'Female') NOT NULL,
        street_address VARCHAR(40) NOT NULL,
        suburb VARCHAR(40) NOT NULL,
        state ENUM('VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT') NOT NULL,
        postcode CHAR(4) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(12) NOT NULL,
        skills TEXT NOT NULL,
        status ENUM('New', 'Current', 'Final') NOT NULL DEFAULT 'New',
        submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $conn->query($table_sql);

        // Helper function: Sanitize input
        function clean_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
        }

        // Validate the Date of Birth
        function validate_dob($dob) {
            var_dump($dob); // Debugging: Check the raw input
        
            // Normalize YYYY-MM-DD format to use slashes
            $dob = str_replace("-", "/", $dob);
        
            // Detect and extract date parts
            if (preg_match("/^\d{4}\/\d{2}\/\d{2}$/", $dob)) { 
                // **YYYY/MM/DD format**
                list($year, $month, $day) = explode("/", $dob);
            } elseif (preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) {
                // **DD/MM/YYYY format**
                list($day, $month, $year) = explode("/", $dob);
            } else {
                die("Error: Invalid date format. Expected dd/mm/yyyy or yyyy/mm/dd.");
            }
        
            // Convert to integers
            $year = (int) $year;
            $month = (int) $month;
            $day = (int) $day;
               
            // Validate date using checkdate()
            if (!checkdate($month, $day, $year)) {
                die("Error: Invalid date provided. Please check month/day.");
            }
        
            // Calculate exact age
            $dob_date = new DateTime("$year-$month-$day");
            $today = new DateTime();
            $age = $today->diff($dob_date)->y;
        
            if ($age < 15 || $age > 80) {
                die("Error: Age must be between 15 and 80.");
            }
        
            return "$year-$month-$day"; // Return MySQL-compatible format
        }
        

        // Retrieve and validate form data
        $errors = [];

        $job_ref = clean_input($_POST['jobnum'] ?? '');
        if (!preg_match("/^[a-zA-Z0-9]{5}$/", $job_ref)) $errors[] = "Job reference number must be exactly 5 alphanumeric characters.";

        $first_name = clean_input($_POST['firstname'] ?? '');
        if (!preg_match("/^[a-zA-Z]{1,20}$/", $first_name)) $errors[] = "First name must be up to 20 alphabetic characters.";

        $last_name = clean_input($_POST['lastname'] ?? '');
        if (!preg_match("/^[a-zA-Z]{1,20}$/", $last_name)) $errors[] = "Last name must be up to 20 alphabetic characters.";

        $dob = clean_input($_POST['birthdate'] ?? '');
        $dob_mysql = validate_dob($dob);
        if (!$dob_mysql) $errors[] = "Date of birth must be in dd/mm/yyyy format and age between 15 and 80.";

        $gender = clean_input($_POST['gender'] ?? '');
        if (!in_array($gender, ['male', 'female'])) $errors[] = "Please select a valid gender.";

        $street_address = clean_input($_POST['str_add'] ?? '');
        if (empty($street_address)) {
        $errors[] = "Street address cannot be empty.";
        } elseif (strlen($street_address) > 40) {
            $errors[] = "Street address must be up to 40 characters.";
        }

        $suburb = clean_input($_POST['town'] ?? '');
        if (empty($suburb)) {
        $errors[] = "Suburb/Town cannot be empty.";
        } elseif (strlen($suburb) > 40) {
            $errors[] = "Suburb/Town must be up to 40 characters.";
        }

        $state = clean_input($_POST['state'] ?? '');
        $valid_states = ["VIC", "NSW", "QLD", "NT", "WA", "SA", "TAS", "ACT"];
        if (!in_array($state, $valid_states)) $errors[] = "State must be one of VIC, NSW, QLD, NT, WA, SA, TAS, ACT.";

        $postcode = clean_input($_POST['postal'] ?? '');
        if (!preg_match("/^\d{4}$/", $postcode)) {
            $errors[] = "Postcode must be exactly 4 digits.";
        } else {
        // Check postcode-state validity
        $state_postcodes = [
        "VIC" => "/^3|^8/", "NSW" => "/^1|^2/", "QLD" => "/^4|^9/",
        "NT" => "/^0/", "WA" => "/^6/", "SA" => "/^5/",
        "TAS" => "/^7/", "ACT" => "/^0/"
        ];
        if (!preg_match($state_postcodes[$state], $postcode)) {
            $errors[] = "Postcode does not match the selected state.";
        }
        }

        $email = clean_input($_POST['email'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";

        $phone = clean_input($_POST['phone'] ?? '');
        if (!preg_match("/^[0-9 ]{8,12}$/", $phone)) $errors[] = "Phone number must be 8 to 12 digits or spaces.";

        $skills = clean_input($_POST['skills'] ?? '');
        if (isset($_POST['other_skills']) && empty($skills)) {
            $errors[] = "Other skills cannot be empty if checked.";
        }

        // If errors exist, redirect to error page
        if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: error.php");
        exit();
        }

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO expressions_of_interest (job_ref, first_name, last_name, dob, gender, street_address, suburb, state, postcode, email, phone, skills) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss", $job_ref, $first_name, $last_name, $dob_mysql, $gender, $street_address, $suburb, $state, $postcode, $email, $phone, $skills);

        if ($stmt->execute()) {
        $eoi_number = $stmt->insert_id;
            echo "<h2>Thank you for your submission!</h2>";
            echo "<p>Your Expression of Interest Number is: <strong>$eoi_number</strong></p>";
        } else {
            echo "<h2>Submission failed</h2><p>There was an issue processing your request.</p>";
        }

        $stmt->close();
        $conn->close();

    ?>
</body>
</html>