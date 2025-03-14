<?php
// index.php - Trang chủ chính
session_start(); // Bắt đầu phiên
include "setting.php";
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
                <div class="card">
                    <section class="card-header">
                        <h2>Fullstack Developer</h2>
                        <p>Reference Number: FSD01</p>
                    </section>
                    <section class="card-body">
                        <h2>Job Description:</h2>
                        <p>Design, develop, and maintain both front-end and back-end systems to 
                            deliver scalable, secure, and user-friendly solutions.</p>
                        <h2>Salary Range:</h2>
                        <p class="card-salary">AUD 85,000 – AUD 120,000 annually</p>
                        <h2>Key Responsibilities</h2>
                        <ol>
                            <li>Develop web applications using modern frameworks and technologies.</li>
                            <li>scalable server-side APIs and database solutions.</li>
                            <li>Collaborate with UI/UX designers for user-friendly interfaces.</li>
                            <li>Optimize code for performance and scalability.</li>    
                        </ol>
                        <h2>Requirements</h2>
                        <ul>
                            <li>
                                <h3>Essential:</h3>
                                <p>Proficiency in HTML, CSS, JavaScript, React, Node.js, and database technologies.</p>
                            </li>
                            <li>
                                <h3>Preferable:</h3>
                                <p>Experience with cloud platforms and CI/CD pipelines.</p>
                            </li>
                        </ul>
                        <h2>Successful Applicant</h2>
                        <p class="card-report">Reports to: IT Infrastructure Manager</p>
                    </section>
                </div>

                <div class="card">
                    <section class="card-header">
                        <h2>Database Manager</h2>
                        <p>Reference Number: DB456</p>
                    </section>
                    <section class="card-body">
                        <h2>Job Description:</h2>
                        <p>Responsible for designing, implementing, and maintaining the company’s
                             database systems to ensure efficient and secure storage and retrieval of data.</p>
                        <h2>Salary Range:</h2>
                        <p class="card-salary">AUD 95,000 – AUD 135,000 annually</p>
                        <h2>Key Responsibilities</h2>
                        <ol>
                            <li>Design and implement database architectures to support the website.</li>
                            <li>Manage database performance, backups, and recovery.</li>
                            <li>Ensure data security and compliance with regulations.</li>
                            <li>Stay updated on VR trends and technologies to propose innovative solutions.</li>
                            <li>Collaborate with developers to integrate databases into the website.</li>  
                        </ol>
                        <h2>Requirements</h2>
                        <ul>
                            <li>
                                <h3>Essential:</h3>
                                <p>Bachelor’s in CS or related, 3+ years in database administration, expertise in 
                                    MySQL/PostgreSQL/MongoDB, strong SQL and optimization skills, familiarity with
                                    data security standards.</p>
                            </li>
                            <li>
                                <h3>Preferable:</h3>
                                <p>Experience with cloud databases (AWS/Azure), knowledge of Python 
                                    or PL/SQL for database programming.</p>
                            </li>
                        </ul>
                        <h2>Successful Applicant</h2>
                        <p class="card-report">Reports to: Finance Lead Manager</p>
                    </section>
                </div>

                <div class="card">
                    <section class="card-header">
                        <h2>IT Project Manager</h2>
                        <p>Reference Number: PM789</p>
                    </section>
                    <section class="card-body">
                        <h2>Job Description:</h2>
                        <p>Oversees the planning, execution, and delivery of the website development project, 
                            ensuring it meets objectives, deadlines, and budget constraints.</p>
                        <h2>Salary Range:</h2>
                        <p class="card-salary">AUD 100,000 – AUD 120,000 annually</p>
                        <h2>Key Responsibilities</h2>
                        <ol>
                            <li>Develop detailed project plans and schedules for website development.</li>
                            <li>Coordinate team activities and ensure collaboration between stakeholders.</li>
                            <li>Monitor project progress and resolve issues.</li>
                            <li>Manage project budgets and resources effectively.</li>
                            <li>Prepare and present project updates to senior management.</li>  
                        </ol>
                        <h2>Requirements</h2>
                        <ul>
                            <li>
                                <h3>Essential:</h3>
                                <p>Bachelor’s in IT/Project Management, 5+ years managing IT projects, expertise in Agile/Scrum,
                                    strong communication/organizational skills, experience with cross-functional teams.</p>
                            </li>
                            <li>
                                <h3>Preferable:</h3>
                                <p>Project management certification (PMP/PRINCE2), 
                                    knowledge of web development processes and technologies.</p>
                            </li>
                        </ul>
                        <h2>Successful Applicant</h2>
                        <p class="card-report">Reports to: IT Infrastructure Manager</p>
                    </section>
                </div>

                <div class="card">
                    <section class="card-header">
                        <h2>UI/UX Designer</h2>
                        <p>Reference Number: UXD01</p>
                    </section>
                    <section class="card-body">
                        <h2>Job Description:</h2>
                        <p>Responsible for designing user-friendly and visually appealing 
                            website interfaces to enhance user experience and engagement.</p>
                        <h2>Salary Range:</h2>
                        <p class="card-salary">AUD 80,000 – AUD 115,000 annually</p>
                        <h2>Key Responsibilities</h2>
                        <ol>
                            <li>Design intuitive user interfaces and experiences for the website.</li>
                            <li>Create wireframes, prototypes, and high-fidelity mockups.</li>
                            <li>Collaborate with developers to ensure designs are accurately implemented.</li>
                            <li>Conduct user research and usability testing to refine designs.</li>
                            <li>Ensure the website is accessible and responsive across devices.</li>  
                        </ol>
                        <h2>Requirements</h2>
                        <ul>
                            <li>
                                <h3>Essential:</h3>
                                <p>Bachelor’s in Graphic/UI/UX Design, 2+ years in UI/UX design, proficiency in Figma/Adobe XD/Sketch,
                                     strong user-centered design knowledge, responsive design and accessibility expertise.</p>
                            </li>
                            <li>
                                <h3>Preferable:</h3>
                                <p>Front-end development experience (HTML, CSS, JavaScript),
                                    familiarity with Agile methodologies.</p>
                            </li>
                        </ul>
                        <h2>Successful Applicant</h2>
                        <p class="card-report">Reports to: IT Infrastructure Manager</p>
                    </section>
                </div>
            </div>
        </main>
        <aside>
            <div class="aside-wrapper">
                <div class="card-flip">
                    <h2 class="card-front">
                        Fullstack Developer<br>
                        FSD01
                    </h2>
                    <div class="card-back">
                        <h2 class="card-back-header">5 days left for recruiting</h2>
                        <div class="card-back-mid">
                            <div class="progress-bar-container">
                                <div id="fsd01-progress-bar"></div>
                                <h2 class="progress-bar-percentage">75%</h2>
                            </div>
                            <ul class="metric-wrapper">
                                <li>
                                    <strong class="metric-stats">75%</strong>
                                    <p> of available space is employed</p>
                                </li>
                                <li>
                                    <strong class="metric-stats">157</strong>
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

                <div class="card-flip">
                    <h2 class="card-front">
                        Database Manager<br>
                        DB456
                    </h2>
                    <div class="card-back">
                        <h2 class="card-back-header">12 days left for recruiting</h2>
                        <div class="card-back-mid">
                            <div class="progress-bar-container">
                                <div id="db456-progress-bar"></div>
                                <h2 class="progress-bar-percentage">57%</h2>
                            </div>
                            <ul class="metric-wrapper">
                                <li>
                                    <strong class="metric-stats">57%</strong>
                                    <p> of available space is employed</p>
                                </li>
                                <li>
                                    <strong class="metric-stats">29</strong>
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

                <div class="card-flip">
                    <h2 class="card-front">
                        IT Project Manager<br>
                        PM789
                    </h2>
                    <div class="card-back">
                        <h2 class="card-back-header">2 days left for recruiting</h2>
                        <div class="card-back-mid">
                            <div class="progress-bar-container">
                                <div id="pm789-progress-bar"></div>
                                <h2 class="progress-bar-percentage">85%</h2>
                            </div>
                            <ul class="metric-wrapper">
                                <li>
                                    <strong class="metric-stats">85%</strong>
                                    <p> of available space is employed</p>
                                </li>
                                <li>
                                    <strong class="metric-stats">39</strong>
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

                <div class="card-flip">
                    <h2 class="card-front">
                        UI/UX Designer<br>
                        UXD01
                    </h2>
                    <div class="card-back">
                        <h2 class="card-back-header">9 days left for recruiting</h2>
                        <div class="card-back-mid">
                            <div class="progress-bar-container">
                                <div id="uxd01-progress-bar"></div>
                                <h2 class="progress-bar-percentage">22%</h2>
                            </div>
                            <ul class="metric-wrapper">
                                <li>
                                    <strong class="metric-stats">22%</strong>
                                    <p> of available space is employed</p>
                                </li>
                                <li>
                                    <strong class="metric-stats">46</strong>
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