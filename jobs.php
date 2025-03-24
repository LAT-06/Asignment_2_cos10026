<?php
// index.php - Trang chủ chính
session_start(); // Bắt đầu phiên
include "setting.php";
$queryGetJobs = "SELECT * FROM jobs";
$result = mysqli_query($conn, $queryGetJobs);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IT web group AS1</title>
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="styles/style-jobs.css">
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
        <div id="page-header" class="text-container">
            <h1>Position Descriptions page</h1>
        </div>
    </header>
    <div id="mid">
        <main>
            <div class="main-wrapper">
                <?php 
                    if(!$result){
                        echo "<h1>Error querying database</h1>";
                    } elseif(mysqli_num_rows($result) == 0) {
                        echo "<h1>No Job is in need</h1>";
                    } elseif(mysqli_num_rows($result) > 0) {
                        while($job = mysqli_fetch_assoc($result)){
                ?>
                    <div class="card">
                        <section class="card-header">
                            <h2><?php echo $job['job_title']?></h2>
                            <p>Reference Number: <?php echo $job['job_ref']?></p>
                        </section>
                        <section class="card-body">
                            <h2>Job Description:</h2>
                            <p><?php echo $job['job_description']?></p>
                            <h2>Salary Range:</h2>
                            <p class="card-salary">AUD <?php
                            $salarymin = $job['salary'] - 10000; 
                            $salarymax = $salarymin + 20000;
                            echo (int) ($salarymin / 1000) . "," . str_pad($salarymin % 1000, 3, '0', STR_PAD_RIGHT) ." - AUD " 
                                . (int) ($salarymax / 1000) . "," . str_pad($salarymax % 1000, 3, '0', STR_PAD_RIGHT)
                            
                            ?> annually</p>
                            <h2>Key Responsibilities</h2>
                            <ol>
                                <?php 
                                $queryGetJobResponsibility = "SELECT job_ref, content FROM jobs_responsibilities WHERE job_ref='" . $job['job_ref'] . "'";
                                $resultResponsibility = mysqli_query($conn, $queryGetJobResponsibility);
                                 while($responsibility = mysqli_fetch_assoc($resultResponsibility)){
                                 ?>
                                     <li><?php echo $responsibility['content']?></li>
                                 <?php }?>
                            </ol>
                            <h2>Requirements</h2>
                            <ul>
                                <li>
                                    <h3>Essential:</h3>
                                    <p><?php echo $job['essential']?></p>
                                </li>
                                <li>
                                    <h3>Preferable:</h3>
                                    <p><?php echo $job['preferable']?></p>
                                </li>
                            </ul>
                            <h2>Successful Applicant</h2>
                            <p class="card-report">Reports to: <?php echo $job['report_to']?></p>
                        </section>
                    </div>

                <?php
                        }
                    }
                ?>
            </div>
        </main>
        <aside>
            <div class="aside-wrapper">
                <?php 
                    $queryGetJobs = "SELECT job_ref, job_title FROM jobs";
                    $result = mysqli_query($conn, $queryGetJobs);
                    if(!$result){
                        echo "<h1>Error querying database</h1>";
                    } elseif(mysqli_num_rows($result) == 0) {
                        echo "<h1>No Job is in need</h1>";
                    } elseif(mysqli_num_rows($result) > 0) {
                        while($job = mysqli_fetch_assoc($result)){
                            $queryGetEOIs = "SELECT COUNT(*) as count FROM eoi WHERE job_ref = '" . $job['job_ref'] ."'";
                            $queryGetEmployedEOIs = "SELECT COUNT(*) as count FROM eoi WHERE job_ref = '" . $job['job_ref'] . "' AND status = 'Final'";

                            $resultEOI = mysqli_query($conn, $queryGetEOIs);
                            $resultEmployedEOIs = mysqli_query($conn, $queryGetEmployedEOIs);
                            // Number of Resumes / CV
                            $rowEOI = mysqli_fetch_assoc($resultEOI);
                            $rowEmployedEOI = mysqli_fetch_assoc($resultEmployedEOIs);

                            $count = $rowEOI['count'];
                            // Number of accepted employee.
                            $countEmployed = $rowEmployedEOI['count'];
                            
                            if($count != 0){
                                $percentageEmployed = (int)($countEmployed * 100 / $count);
                            } else {
                                $percentageEmployed = 0;
                            }
                            
                ?>
                        <details>
                            <summary>
                                <div class="card-flip">
                                    <h2 class="card-front">
                                        <?php echo $job['job_title']?><br>
                                        <?php echo $job['job_ref']?>
                                    </h2>
                                    <div class="card-back">
                                        <h2 class="card-back-header">7 days left for recruiting</h2>
                                        <div class="card-back-mid">
                                            <div class="progress-bar-container">
                                                <div class="progress-bar" style="height: <?php
                                                echo $percentageEmployed;
                                                 ?>%;" ></div>
                                                <h2 class="progress-bar-percentage"><?php
                                                echo $percentageEmployed . "%";
                                                 ?></h2>
                                            </div>
                                            <ul class="metric-wrapper">
                                                <li>
                                                    <strong class="metric-stats"><?php
                                                    echo $percentageEmployed . "%";
                                                    ?></strong>
                                                    <p> of available space is employed</p>
                                                </li>
                                                <li>
                                                    <strong class="metric-stats"><?php
                                                     echo $count
                                                     ?></strong>
                                                    <p> resumes, CVs are received</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-back-footer">
                                            <h3>Be one of us!</h3><br>
                                            <h3>We are looking for you!</h3>
                                        </div>
                                    </div>
                                </div>
                            </summary>
                        </details>

                <?php
                        }
                    }
                ?>
            </div>  
        </aside>
    </div>
    <footer>
        <p>&copy; 2024 TechForce Solutions. All rights reserved.</p>
        <p>Contact us: <a href="mailto:group@example.com">group@example.com</a></p>
    </footer>
</body>
</html>

<!-- Change down here -->