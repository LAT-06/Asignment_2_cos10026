<h3>Job Label</h3>
    <label for="jobRef">Job Reference Number (5 alphanumeric letter)</label>
    <input type="text" id="jobRef" name="jobRef" pattern="^[A-Za-z0-9]{5}$" minlength="5" maxlength="5" required>
    <label for="jobTitle">Job Title</label>
    <input type="text" id="jobTitle" name="jobTitle" pattern="[a-zA-Z\s]+" minlength="2" maxlength="200" required> 
<h3>Job Details</h3>
    <label for="jobDesc">Job Description:</label>
    <textarea id="jobDesc" name="jobDesc" rows="4" minLength="10" maxlength="4000" required></textarea>
    <label for="salary">Salary:</label>
    <input type="number" id="salary" name="salary" min="1000" max="300000" required>
    <label for="numberOfEmployee">Number of Employee</label>
    <input type="number" id="numberOfEmployee" name="numberOfEmployee" min="2" max="1000" required>
<h3>Requirements</h3>
    <label for="essential">Essential</label>
    <textarea id="essential" name="essential" rows="2" minlength="10" maxlength="400" required></textarea>
    <label for="preferable">Preferable</label>
    <textarea id="preferable" name="preferable" rows="2" minlength="10" maxlength="400" required></textarea>
    <label for="numberOfResponsibility">Number of Responsibilities</label>
    <input type="number" id="numberOfResponsibility" name="numberOfResponsibility" min="3" required>
<h3>Successful Applicant</h3>
    <label for="reportTo">Reports to</label>
    <input type="text" id="reportTo" name="reportTo" minlength="10" maxlength="200" required>