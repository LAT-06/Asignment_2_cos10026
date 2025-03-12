<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT web group AS1</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/style-apply.css">
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
        </header>

        <header>
            <div class="title">
                <h1><strong>Application Form</strong></h1>
            </div>
        </header>

    <div class="form-container">               
        <div>
            <form id="applyform" method="post" action="https://mercury.swin.edu.au/it000000/formtest.php">
                <div class="user-details">
                    <div class="input-box">
                        <label class="details" for="jobnum">Job Reference Number</label>
                        <input type="text" id="jobnum" name="jobnum" pattern="[a-zA-Z0-9]{5}" required>
                    </div>
                    
                    <div class="input-box">
                        <label  class="details" for="firstname">First Name</label>
                        <input type="text" id="firstname" name="firstname" maxlength="20" pattern="[a-zA-Z\s]{}" required>
                    </div>

                    <div class="input-box">
                        <label  class="details" for="lastname">Last Name</label>
                        <input type="text" id="lastname" name="lastname" maxlength="20" pattern="[A-Za-z\s]{}" required>
                    </div>
        
                    <div class="input-box">
                        <label class="details" for="birthdate">Date of Birth</label><br>
                        <input type="date" id="birthdate" name="birthdate" required>
                    </div>
        
                    <div class="input-box">
                        <fieldset class="gender-details">
                            
                            
                            <legend class="gender-title">Gender</legend>  
                                <div class="category">
                                    <label class="gender" for="male">Male</label>
                                    <input type="radio" id="male" name="gender" checked="checked" value="male">                                    
                                    <label class="gender" for="female">Female</label>  
                                    <input type="radio" id="female" name="gender" value="female">                       
                            </div>
                        </fieldset>
                    </div>
        
                    <div class="input-box">
                        <label class="details" for="strad">Street Address</label>
                            <input type="text" id="strad" name="str_add"  maxlength="40" required>                       
                    </div>
        
                    <div class="input-box">
                        <label for="town">Suburb/Town</label>
                        <input type="text" id="town" name="town" maxlength="40"  required>
                    </div>
        
                    <div class="input-box">
                        <label for="state">State</label>
        
                        <div>
                            <select name="state" id="state" required>
                                <option value="">Select your State</option>
                                <option value="VIC">VIC</option>
                                <option value="NSW">NSW</option>
                                <option value="QLD">QLD</option>
                                <option value="NT">NT</option>
                                <option value="WA">WA</option>
                                <option value="SA">SA</option>
                                <option value="TAS">TAS</option>
                                <option value="ACT">ACT</option>
                            </select>
                        </div>
                    </div>
        
                    <div class="input-box">
                        <label for="postal">Postcode</label>
        
                        <div>
                            <input type="text" id="postal" name="postal" pattern="[0-9]{4}" required>
                        </div>
                    </div>
        
                    <div class="input-box">
                        <label for="email">Email Address</label>
                        <div>
                            <input type="email" id="email" name="email" required>
                        </div>
                    </div>
    
                    <div class="input-box">
                        <label for="phone">Phone Number</label>
                        <div>
                            <input type="text" id="phone" name="phone" pattern="[0-9\s]{8,12}" required>
                        </div>
                    </div>
    
                    <div class="input-box">
                        <label><u>Skills</u></label>
                        <div class="skill-category">
                                <label for="technical">Technical</label>
                                <input type="checkbox" name="skill" id="technical" value="technical">

                                <label for="soft">Soft</label>
                                <input type="checkbox"  name="skill" id="soft" value="soft">
                            
                                <label for="other">Other Skills...</label>
                                <input type="checkbox" name="skill" id="other" value="other"> 
                        </div>
                        <textarea placeholder="Other skills..." cols="42" rows="4" name="other"></textarea>
                    </div>

                    <div class="button">
                        <input type="submit" value="Apply">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 The Supreme Animal Quartet. All rights reserved.</p>
        <p>Contact us: <a href="mailto:group@example.com">group@example.com</a></p>
    </footer>
</body>
</html>