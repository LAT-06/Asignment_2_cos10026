<?php
session_start();

// Kiểm tra nếu không phải admin thì không cho vào trang manage.php
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require_once 'setting.php'; // Include database connection file

function listAllEOIs($conn) {
    $query = "SELECT * FROM EOI";
    $result = mysqli_query($conn, $query);
    return $result;
}

function listEOIsByPosition($conn, $jobRef) {
    $query = "SELECT * FROM eoi WHERE job_reference_number = ?";
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
    $query = "DELETE FROM eoi WHERE job_reference_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $jobRef);
    return $stmt->execute();
}

function changeEOIStatus($conn, $eoiId, $status) {
    $query = "UPDATE eoi SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $eoiId);
    return $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_job_ref'])) {
        deleteEOIsByJobRef($conn, $_POST['delete_job_ref']);
    } elseif (isset($_POST['change_status_id']) && isset($_POST['new_status'])) {
        changeEOIStatus($conn, $_POST['change_status_id'], $_POST['new_status']);
    }
}

$allEOIs = listAllEOIs($conn);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
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
    <div id="idk">
        <h1>Admin Management Page</h1>
        <h2>List of all EOIs</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Job Reference Number</th>
                <th>Status</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($allEOIs)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['job_reference_number']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <h2>Delete EOIs by Job Reference Number</h2>
        <form method="post" action="manage.php">
            <label for="delete_job_ref">Job Reference Number:</label>
            <input type="text" id="delete_job_ref" name="delete_job_ref" required>
            <button type="submit">Delete</button>
        </form>

        <h2>Change EOI Status</h2>
        <form method="post" action="manage.php">
            <label for="change_status_id">EOI ID:</label>
            <input type="text" id="change_status_id" name="change_status_id" required>
            <label for="new_status">New Status:</label>
            <input type="text" id="new_status" name="new_status" required>
            <button type="submit">Change Status</button>
        </form>
    </div>

</body>
</html>
