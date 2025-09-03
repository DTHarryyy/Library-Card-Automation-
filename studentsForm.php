<?php
    include('./backend/addingStudent.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/general.css">
    <link rel="stylesheet" href="./style/form.css">
    <title>CSUA-Lib Student Form</title>
</head>
<body>
    <section id="formSection">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" id="form">
            <h1>Student Information</h1>
            <p class="light-text" style="margin-bottom: 30px;">
                Please fill in the required details below.
            </p>

            <h2>Personal Information</h2>
            <div class="inputBox">
                <input type="text" name="full_name" id="full_name" placeholder=" " required>
                <label for="full_name">Full Name:</label>
            </div>
            <div class="inputBox">
                <input type="text" name="address" id="address" placeholder=" " required>
                <label for="Adress">Address:</label>
            </div>

            <h2>Academic Information</h2>
            <div class="inputBox">
                <input type="text" name="student_id_number" id="student_id_number" placeholder=" " required>
                <label for="student_id_number">Student ID:</label>
            </div>

            <div class="dropDown">
                <label for="department">Department</label>
                <select name="department" id="department" required>
                    <option value="">Select Department...</option>
                    <option value="College of Information and Computing Sciences">College of Information and Computing Sciences</option>
                    <option value="College of Teaching Education">College of Teaching Education</option>
                    <option value="College of Fisheries and Aquatic Sciences">College of Fisheries and Aquatic Sciences</option>
                    <option value="College of Criminal Justice Education">College of Criminal Justice Education</option>
                    <option value="College of Human Management">College of Hospitality Management</option>
                    <option value="College of Business, Economics and Accountancy">College of Business, Economics and Accountancy</option>
                    <option value="College of Industrial Technology">College of Industrial Technology</option>
                </select>
            </div>
            <div class="errorMessage">
                <p style="color: red;"><?= $message ?></p>
            </div>
            <button type="submit" class="submitBtn">Add Student</button>
        </form>
    </section>
</body>
</html>
