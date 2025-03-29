<?php
session_start();
require_once "setting.php";
function sanitizeNumber($input){
    return ltrim($input, '0') ? : '0';
}
    $expectedSalary = $_POST["expectedSalary"];
    $expectedSalary = sanitizeNumber($expectedSalary);
    
    $sortDirection = $_POST["sortDirection"];
    $queryGetJobs =     "SELECT * FROM jobs WHERE $expectedSalary 
                        BETWEEN salary - 10000 AND salary + 10000
                        ORDER BY salary $sortDirection;";
    $asideQueryGetJobs = "SELECT job_ref, job_title FROM jobs WHERE $expectedSalary 
    BETWEEN salary - 10000 AND salary + 10000
    ORDER BY salary $sortDirection;";
    if($expectedSalary == 0){
        $queryGetJobs = "SELECT * FROM jobs";
        $asideQueryGetJobs = "SELECT job_ref, job_title FROM jobs";
    }
    $_SESSION['queryGetJobs'] = $queryGetJobs;
    $_SESSION['asideQueryGetJobs'] = $asideQueryGetJobs;
    header("Location: jobs.php");
    exit();
?>