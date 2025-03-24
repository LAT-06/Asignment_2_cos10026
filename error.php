<?php
session_start();
if (!isset($_SESSION['errors'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Submission Error</title>
</head>
<body>
    <h2>Error in Submission</h2>
    <ul>
        <?php
        foreach ($_SESSION['errors'] as $error) {
            echo "<li>$error</li>";
        }
        // session_unset();
        ?>
    </ul>
    <a href="apply.php">Go back to the form</a>
</body>
</html>