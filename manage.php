<?php
session_start();

// Kiểm tra nếu không phải admin thì không cho vào trang manage.php
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require_once 'setting.php'; // Include database connection file

function listAllEOIs($conn) {
    $query = "SELECT * FROM eoi";
    $result = mysqli_query($conn, $query);
    return $result;
}

function listEOIsByPosition($conn, $jobRef) {
    $query = "SELECT * FROM eoi WHERE job_ref = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $jobRef);
    $stmt->execute();
    return $stmt->get_result();
}

function listEOIsByApplicant($conn, $firstName, $lastName) {
    $query = "SELECT * FROM eoi WHERE first_name = ? OR last_name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $firstName, $lastName);
    $stmt->execute();
    return $stmt->get_result();
}

function deleteEOIsByJobRef($conn, $jobRef) {
    $query = "DELETE FROM eoi WHERE job_ref = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $jobRef);
    return $stmt->execute();
}

function changeEOIStatus($conn, $eoiId, $status) {
    $query = "UPDATE eoi SET status = ? WHERE eoi_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $eoiId);
    return $stmt->execute();
}

$allEOIsByPosition = null;
$allEOIsByApplicant = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_job_ref'])) {
        deleteEOIsByJobRef($conn, $_POST['delete_job_ref']);
    } 
    elseif (isset($_POST['change_status_id']) 
    && isset($_POST['new_status'])) {
        changeEOIStatus($conn, $_POST['change_status_id'], 
        $_POST['new_status']);
    }  
    elseif (isset($_POST['search_job_ref'])) {
        $jobRef = $_POST['search_job_ref'];
        $allEOIsByPosition = listEOIsByPosition($conn, $jobRef);
    } 
    elseif (isset($_POST['first_name']) && isset($_POST['last_name'])) {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $allEOIsByApplicant = listEOIsByApplicant($conn, $firstName, $lastName);
    }
}

$allEOIs = listAllEOIs($conn);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta viewport="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Manage</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/style-manage.css">
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
    </header>
    <div id="all_eois">
        <h1>Admin Management Page</h1>
        <div id="all_eois_table">          
            <table>
                <caption><h2>List of all EOIs</h2></caption>
                <tr>
                    <th>ID</th>
                    <th>Job Reference Number</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Street Address</th>
                    <th>Suburb</th>
                    <th>State</th>
                    <th>Postcode</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Skills</th>
                    <th>Status</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($allEOIs)): ?>
                    <tr>
                        <td><?php echo $row['eoi_id']; ?></td>
                        <td><?php echo $row['job_ref']; ?></td>
                        <td><?php echo $row['first_name']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['dob']; ?></td>
                        <td><?php echo $row['gender']; ?></td>
                        <td><?php echo $row['street_address']; ?></td>
                        <td><?php echo $row['suburb']; ?></td>
                        <td><?php echo $row['state']; ?></td>
                        <td><?php echo $row['postcode']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['skills']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div id="search_eois_by_job_ref">
            <h2>Search EOIs by Job Reference Number</h2>
            <form method="post" action="manage.php">
                <label for="search_job_ref">Job Reference Number:</label>
                <input type="text" id="search_job_ref" name="search_job_ref">
                
                <button class="submitBTN" type="submit">Search</button>
            </form>
        </div>
        
        <div id="all_eois_by_position_table">
            <table>
                <caption><h2>List of all EOIs by Job Reference</h2></caption>
                <tr>
                    <th>ID</th>
                    <th>Job Reference Number</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Street Address</th>
                    <th>Suburb</th>
                    <th>State</th>
                    <th>Postcode</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Skills</th>
                    <th>Status</th>
                </tr>
                <?php if (@$allEOIsByPosition->num_rows > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($allEOIsByPosition)): ?>
                        <tr>
                            <td><?php echo $row['eoi_id']; ?></td>
                            <td><?php echo $row['job_ref']; ?></td>
                            <td><?php echo $row['first_name']; ?></td>
                            <td><?php echo $row['last_name']; ?></td>
                            <td><?php echo $row['dob']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td><?php echo $row['street_address']; ?></td>
                            <td><?php echo $row['suburb']; ?></td>
                            <td><?php echo $row['state']; ?></td>
                            <td><?php echo $row['postcode']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['skills']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="14">No records found.</td></tr>
                <?php endif; ?>
            </table>
        </div>

        <div id="search_eois_by_applicant">
            <h2>Search EOIs by Applicant</h2>
            <form method="post" action="manage.php">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name">
                 
                <button class="submitBTN" type="submit">Search</button>
            </form>
        </div>
        
        <div id="all_eois_by_applicant_table">
            <table>
                <caption><h2>List of all EOIs by Applicant</h2></caption>
                <tr>
                    <th>ID</th>
                    <th>Job Reference Number</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Street Address</th>
                    <th>Suburb</th>
                    <th>State</th>
                    <th>Postcode</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Skills</th>
                    <th>Status</th>
                </tr>
                <?php if (@$allEOIsByApplicant->num_rows > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($allEOIsByApplicant)): ?>
                        <tr>
                            <td><?php echo $row['eoi_id']; ?></td>
                            <td><?php echo $row['job_ref']; ?></td>
                            <td><?php echo $row['first_name']; ?></td>
                            <td><?php echo $row['last_name']; ?></td>
                            <td><?php echo $row['dob']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td><?php echo $row['street_address']; ?></td>
                            <td><?php echo $row['suburb']; ?></td>
                            <td><?php echo $row['state']; ?></td>
                            <td><?php echo $row['postcode']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['skills']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="14">No records found.</td></tr>
                <?php endif; ?>
            </table>
        </div>
        

        <div id="delete_by_job_ref">
            <h2>Delete EOIs by Job Reference Number</h2>
            <form method="post" action="manage.php">
                <label for="delete_job_ref">Job Reference Number:</label>
                <input type="text" id="delete_job_ref" name="delete_job_ref" required>
                
                <button class="submitBTN" type="submit">Delete</button>
            </form>
        </div>

        <div id="change_status">
            <h2>Change EOI Status</h2>
            <form method="post" action="manage.php">
                <label for="change_status_id">EOI ID:</label>
                <input type="text" id="change_status_id" name="change_status_id" required>

                <label for="new_status">New Status:</label>
                <select name="new_status" id="new_status" required>
                    <option value="">Select New Status</option>
                    <?php
                    $new_status = array('New', 'Current', 'Final');
                    foreach ($new_status as $new_status) {
                        $selected = (isset($form_data['new_status']) && $form_data['new_status'] == $new_status) ? 'selected' : '';
                        echo "<option value=\"$new_status\" $selected>$new_status</option>";
                    }
                    ?>
                </select>

                <button class="submitBTN" type="submit">Change</button>
            </form>
        </div>
    </div>

</body>
</html>
