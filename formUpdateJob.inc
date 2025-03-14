<h2 class="updateTitle">Job Reference Number: <?php echo $jobRef?></h2>
<h3>Job Label</h3>
    <label for="jobTitle">Job Title</label>
    <input type="text" id="jobTitle" name="jobTitle" pattern="[a-zA-Z\s]+" value="<?php echo $jobTitle?>" minlength="2" maxlength="200" required> 
<h3>Job Details</h3>
    <label for="jobDesc">Job Description</label>
    <textarea id="jobDesc" name="jobDesc" rows="4" minLength="10" maxlength="4000" required><?php echo $jobDesc?></textarea>
    <label for="salary">Salary</label>
    <input type="number" id="salary" name="salary" value="<?php echo $salary?>"min="1000" max="300000" required>
    <label for="numberOfEmployee">Number of Employee</label>
    <input type="number" id="numberOfEmployee" name="numberOfEmployee" value="<?php echo $numberOfEmployee?>" min="2" max="1000" required>
<h3>Requirements</h3>
    <label for="essential">Essential</label>
    <textarea id="essential" name="essential" rows="2"  minlength="10" maxlength="400" required><?php echo $essential?></textarea>
    <label for="preferable">Preferable</label>
    <textarea id="preferable" name="preferable" rows="2" minlength="10" maxlength="400" required><?php echo $preferable?></textarea>
<h3>Successful Applicant</h3>
    <label for="reportTo">Reports to</label>
    <input type="text" id="reportTo" name="reportTo" value="<?php echo $reportTo?>"minlength="10" maxlength="200" required>
