<?php
session_start();

// Kiểm tra nếu không phải admin thì không cho vào trang manage.php
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: index.php");
    exit();
}
require_once "setting.php";

$step = (isset($_SESSION['step'])) ? $_SESSION['step'] : 1;
$option = (isset($_SESSION['option'])) ? $_SESSION['option'] : "error";
$jobRef = (isset($_SESSION['jobRef'])) ? $_SESSION['jobRef'] : "00000";
$jobTitle = (isset($_SESSION['jobTitle'])) ? $_SESSION['jobTitle'] : "job title";
$jobDesc = (isset($_SESSION['jobDesc'])) ? $_SESSION['jobDesc'] : "job description";
$salary = (isset($_SESSION['salary'])) ? $_SESSION['salary'] : 10000;
$essential = (isset($_SESSION['essential'])) ? $_SESSION['essential'] : "essential";
$preferable = (isset($_SESSION['preferable'])) ? $_SESSION['preferable'] : "preferable";
$numberOfResponsibility = (isset($_SESSION['numberOfResponsibility'])) ? $_SESSION['numberOfResponsibility'] : 3;
$numberOfEmployee =  (isset($_SESSION['numberOfEmployee'])) ? $_SESSION['numberOfEmployee'] : 2;
$reportTo = (isset($_SESSION['reportTo'])) ? $_SESSION['reportTo'] : "reportTo";
$content = (isset($_SESSION['responsibility'])) ? $_SESSION['responsibility'] : ["DResponsibility 1", "DResponsibility 2", "DResponsibility 3"];
$fetchQuery = (isset($_SESSION['fetchQuery'])) ? $_SESSION['fetchQuery'] : "fetchQuery";

function ClearManageJobsData(){
        $_SESSION['step'] = 1;
        $_SESSION['option'] = "error";
        $_SESSION['jobRef'] = "00000";
        unset($_SESSION['jobRef'], $_SESSION['jobTitle'], $_SESSION['jobDesc'],
        $_SESSION['salary'], $_SESSION['essential'], $_SESSION['preferable'],
        $_SESSION['numberOfResponsibility'], $_SESSION['reportTo'],
        $_SESSION['responsibility'], $_SESSION['numberOfEmployee']
        );
        $step = 1;
        header("Location: jobs_manage.php");
        exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($step == 1){
        // Optimize step later
        if(isset($_POST['option'])){    
            $option = $_POST['option'];
            $_SESSION['option'] = $option;
            $_SESSION['step'] = 2;
            $step = 2;
        }
    } elseif($step == 2){
        // if Submitting at step 2
        if($option == "delete" && isset($_POST['jobRef'])){
            // option = delete
            $jobRef = $_POST['jobRef'];
            $_SESSION['jobRef'] = $jobRef;
            $_SESSION['step'] = 3;
            $step = 3;
        } elseif($option == "insert"){
            // option = insert
            if(!isset($_SESSION['numberOfResponsibility'])){
                // if when submitted, numberOfResponsibility is not stored in SESSION
                $jobRef =  $_POST['jobRef'];
                $_SESSION['jobRef'] = $jobRef;
                $jobTitle = $_POST['jobTitle'];
                $_SESSION['jobTitle'] = $jobTitle;
                $jobDesc = $_POST['jobDesc'];
                $_SESSION['jobDesc'] = $jobDesc;
                $salary = $_POST['salary'];
                $_SESSION['salary'] = $salary;
                $essential = $_POST['essential'];
                $_SESSION['essential'] = $essential;
                $preferable =  $_POST['preferable'];
                $_SESSION['preferable'] = $preferable;
                $numberOfResponsibility = $_POST['numberOfResponsibility'];
                $_SESSION['numberOfResponsibility'] = $numberOfResponsibility;
                $numberOfEmployee = $_POST['numberOfEmployee'];
                $_SESSION['numberOfEmployee'] = $numberOfEmployee;
                $reportTo = $_POST['reportTo'];
                $_SESSION['reportTo'] = $reportTo;
            } else {
                // if when submitted, numberOfResponsibility is already stored in SESSION
                if(!isset($_SESSION['responsibility'])){
                    // if when submitted, responsibility is not stored in SESSION
                    $content = $_POST['responsibility'];
                    $_SESSION['responsibility'] = $content;
                    $_SESSION['step'] = 3;
                    $step = 3;
                }
            }
        } elseif($option == "update"){
            if(!isset($_SESSION['jobRef'])){
                $sql_table = "jobs";
                $jobRef = $_POST['jobRef'];
                $_SESSION['jobRef'] = $jobRef;
                $fetchQuery = "SELECT * FROM $sql_table WHERE job_ref = '$jobRef'";
                $result = mysqli_query($conn, $fetchQuery);
                if(mysqli_num_rows($result) == 0){
                    ClearManageJobsData();
                }else {
                    $job = mysqli_fetch_assoc($result);
                    //  if(isset($_SESSION['jobDesc']) && $_SESSION['jobDesc'] != null){
                    $_SESSION['jobTitle'] = $job['job_title'];
                    $jobTitle = $job['job_title'];
                    $_SESSION['jobDesc'] = $job['job_description'];
                    $jobDesc = $job['job_description'];
                    $_SESSION['salary'] = $job['salary'];
                    $salary = $job['salary'];
                    $_SESSION['essential'] = $job['essential'];
                    $essential = $job['essential'];
                    $_SESSION['preferable'] = $job['preferable'];
                    $preferable = $job['preferable'];
                    $_SESSION['reportTo'] = $job['report_to'];
                    $reportTo = $job['report_to'];
                    $_SESSION['numberOfEmployee'] = $job['number_of_employee'];
                    $numberOfEmployee = $job['number_of_employee'];
                    //  }
                }
                
                
                
            } else {
                if(isset($_POST['jobTitle'])){
                    $jobTitle = $_POST['jobTitle'];
                    $_SESSION['jobTitle'] = $jobTitle;
                    $jobDesc = $_POST['jobDesc'];
                    $_SESSION['jobDesc'] = $jobDesc;
                    $salary = $_POST['salary'];
                    $_SESSION['salary'] = $salary;
                    $essential = $_POST['essential'];
                    $_SESSION['essential'] = $essential;
                    $preferable =  $_POST['preferable'];
                    $_SESSION['preferable'] = $preferable;
                    $reportTo = $_POST['reportTo'];
                    $_SESSION['numberOfEmployee'] = $numberOfEmployee;
                    $numberOfEmployee = $_POST['numberOfEmployee'];
                    $_SESSION['reportTo'] = $reportTo;
                    $_SESSION['step'] = 3;
                    $step = 3;
                }
            }
        }
    } elseif($step == 3){
        $step = 1;
        ClearManageJobsData();
    }
}



?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/style-jobs_manage.css">
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
    
    <div id="manageWrapper">
        <h1>Admin Jobs Management</h1>
        <div class="form-area">
            <form method="POST">
                <?php if($step == 1): ?>
                <h2>Select Option</h2>
                <?php
                require_once "formSelectOption.inc";
                elseif($step==2):
                    if($option=="delete"):
                        echo "<h2>Delete Jobs</h2>";
                        $queryGetJob = "SELECT job_ref, job_title FROM jobs";
                        $result = mysqli_query($conn, $queryGetJob);
                        if (mysqli_num_rows($result) > 0):
                        ?>
                            <table>
                                <tr>
                                    <th>Job Reference Number</th>
                                    <th>Job Title</th>
                                </tr>
                                    <?php while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr><td>" .$row["job_ref"] . "</td>";
                                        echo "<td>" .$row["job_title"] . "</td></tr>";
                                    }
                                    ?>
                            </table>
                            <br>
                        <?php
                        endif;
                        require_once "formDeleteJob.inc"; 
                    elseif($option=="insert"):
                        echo "<h2>Insert Jobs</h2>";
                        if(!isset($_SESSION['numberOfResponsibility'])){
                            require_once "formInsertJob.inc";
                        } else {
                            if(!isset($_SESSION['jobRef']) || isset($_SESSION['responsibility'])){
                                ClearManageJobsData();
                            } else {
                                for($i = 1; $i <= $numberOfResponsibility; $i++){
                                    ?>
                                        <label for="responsibility[]">Responsibility <?php echo $i?>:</label> 
                                        <textarea id="responsibility" name="responsibility[]" rows="2" minlength="10" maxlength="400" required></textarea>
                                    <?php
                                }
                            }
                        }
                    elseif($option == "update"):
                        echo "<h2>Update Jobs</h2>";
                        
                        if(!isset($_SESSION['jobRef'])):
                        $queryGetJob = "SELECT job_ref, job_title FROM jobs";
                        $result = mysqli_query($conn, $queryGetJob);
                        if (mysqli_num_rows($result) > 0) {
                        ?>
                            <table>
                                <tr>
                                    <th>Job Reference Number</th>
                                    <th>Job Title</th>
                                </tr>
                                    <?php while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr><td>" .$row["job_ref"] . "</td>";
                                        echo "<td>" .$row["job_title"] . "</td></tr>";
                                    }
                                    ?>
                            </table>
                            <br>
                        <?php
                        } else {
                            echo "No jobs found";
                        }?>
                            <div class="option">
                                <label for="jobRef">Job Reference Number (5 alphanumeric letter)</label>
                                <input type="text" id="jobRef" name="jobRef" pattern="^[A-Za-z0-9]{5}$" minlength="5" maxlength="5" required>
                            </div>

                        <?php
                        elseif(isset($_SESSION['jobRef'])  && isset($_SESSION['jobTitle']) && $_SESSION['jobTitle'] != null):
                            require_once "formUpdateJob.inc";
                        else:
                            ClearManageJobsData();
                        endif;
                    ?>
                    <?php endif; ?>
                <?php
                elseif($step==3):
                    if ($option == "delete"):
                        echo "<h2>Delete Results:</h2>";
                        
                        $sql_table = "jobs";
                        $getJobQuery = "SELECT job_ref FROm $sql_table WHERE job_ref = '$jobRef'";
                        $result = mysqli_query($conn, $getJobQuery);
                        if(mysqli_num_rows($result) == 0){
                            ClearManageJobsData();
                        } else {
                            $deleteQueryJobs = "DELETE FROM $sql_table WHERE job_ref = '$jobRef'";
                            $result = mysqli_query($conn, $deleteQueryJobs);
                            if($result){
                                echo "<p>$jobRef is deleted successfully in $sql_table</p>";
                            } else {
                                echo "<p>$jobRef failed to delete in $sql_table</p>";
                            }
                            $sql_table = "jobs_responsibilities";
                            $deleteQueryJobsResponsibilities = "DELETE FROM $sql_table WHERE job_ref = '$jobRef'";
                            $result = mysqli_query($conn, $deleteQueryJobsResponsibilities);
                            if($result){
                                echo "<p>$jobRef is deleted successfully in $sql_table</p>";
                            } else {
                                echo "<p>$jobRef failed to delete in $sql_table</p>";
                            }
                        }
                    elseif($option == "insert"):
                        echo "<h2>Insert Results:</h2>";
                        $sql_table = "jobs";
                        $insertQueryJobs = "INSERT INTO $sql_table (job_ref, job_title, job_description, salary, essential, preferable, report_to, number_of_responsibilities, number_of_employee) 
                                            VALUES ('$jobRef', '$jobTitle', '$jobDesc', '$salary', '$essential', '$preferable', '$reportTo', '$numberOfResponsibility', '$numberOfEmployee')";
                        $result = mysqli_query($conn, $insertQueryJobs);
                        if($result){
                            echo "<p>$jobRef is inserted successfully in $sql_table</p>";
                        } else {
                            echo "<p>$jobRef failed to insert in $sql_table</p>";
                        }
                        $sql_table = "jobs_responsibilities";
                        foreach($content as $responsibility){
                            $insertQueryJobsResponsibilities = "INSERT INTO $sql_table (job_ref, content)
                            VALUES ('$jobRef', '$responsibility')";
                            $result = mysqli_query($conn, $insertQueryJobsResponsibilities);
                        }
                        if($result){
                            echo "<p>$jobRef is inserted successfully in $sql_table</p>";
                        } else {
                            echo "<p>$jobRef failed to insert in $sql_table</p>";
                        }
                    elseif($option == "update"):
                        $sql_table = "jobs";
                        echo "<h2>Update Result:</h2>";
                        $queryUpdateJobTitle = "UPDATE $sql_table SET job_title = '$jobTitle' WHERE job_ref='$jobRef'";
                        $result = mysqli_query($conn, $queryUpdateJobTitle);
                        if($result){
                            echo "<p>Job Title: $jobTitle updated successfully to $sql_table</p>";
                        } else {
                            echo "<p>error with query $queryUpdateJobTitle</p>";
                        }

                        $queryUpdateJobDesc = "UPDATE $sql_table SET job_description = '$jobDesc' WHERE job_ref='$jobRef'";
                        $result = mysqli_query($conn, $queryUpdateJobDesc);


                        $queryUpdateSalary = "UPDATE $sql_table SET salary = $salary WHERE job_ref='$jobRef'";
                        $result = mysqli_query($conn, $queryUpdateSalary);
                        if($result){
                            echo" <p>Salary: $salary updated successfuly to $sql_table</p>";
                        }

                        $queryUpdateNumberOfEmployee = "UPDATE $sql_table SET number_of_employee = $numberOfEmployee WHERE job_ref='$jobRef'";
                        $result = mysqli_query($conn, $queryUpdateNumberOfEmployee);
                        if($result){
                            echo "<p>Number Of Employee: $numberOfEmployee updated successfully to $sql_table</p>";
                        }

                        $queryUpdateEssential = "UPDATE $sql_table SET essential = '$essential' WHERE job_ref='$jobRef'";
                        $result = mysqli_query($conn, $queryUpdateEssential);
                        if($result){
                            echo "<p>Essential: $essential updated successfully to $sql_table</p>";
                        }

                        $queryUpdatePreferable = "UPDATE $sql_table SET preferable = '$preferable' WHERE job_ref='$jobRef'";
                        $result = mysqli_query($conn, $queryUpdatePreferable);
                        if($result){
                            echo "<p>Preferable: $preferable updated successfully to $sql_table</p>";
                        }


                        $queryUpdateReportTo = "UPDATE $sql_table SET report_to= '$reportTo' WHERE job_ref='$jobRef'";
                        $result = mysqli_query($conn, $queryUpdateReportTo);
                        if($result){
                            echo "<p>Report To: $reportTo updated successfully to $sql_table</p>";
                        }
                    endif;
                ?>
                <?php endif; 
                if($step < 3):?>
                    <input class="submitBtn" type="submit" value="Submit">
                <?php else: ?>
                    <input class="submitBtn" type="submit" value="Back">
                <?php endif; ?>
            </form>
        </div>
        <?php

        ?>
    </div>

</body>
</html>
