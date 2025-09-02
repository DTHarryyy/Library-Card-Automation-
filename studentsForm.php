<?php
    session_start();
    include('./backend/database_information.php');
    $message = ""; 

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sanitize input
            $full_name = htmlspecialchars(trim($_POST['full_name']));
            $student_id_number = htmlspecialchars(trim($_POST['student_id_number']));
            $address = htmlspecialchars(trim($_POST['address']));
            $department = htmlspecialchars(trim($_POST['department']));

            // Example: current logged-in user (hardcoded for demo, replace with session user ID)
            $added_by_user_id = 1;

            // Validate required fields
            if (!empty($full_name) && !empty($student_id_number) && !empty($department)) {
                
                // Insert with prepared statement
                $sql = "INSERT INTO students (full_name, address, department, student_id_number, added_by_user_id) 
                        VALUES (:full_name, :address, :department,  :student_id_number, :added_by_user_id)";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
                $stmt->bindParam(':address', $address, PDO::PARAM_STR);
                $stmt->bindParam(':department', $department, PDO::PARAM_STR);
                $stmt->bindParam(':student_id_number', $student_id_number, PDO::PARAM_STR);
                $stmt->bindParam(':added_by_user_id', $added_by_user_id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $message = "<p style='color:green;'>Student added successfully!</p>";
                    $full_name = "";
                    $student_id_number = "";
                    $address = "";
                    $department = "";
                } else {
                    $message = "<p style='color:red;'>Error: Could not add student.</p>";
                }
            } else {
                $message = "<p style='color:red;'>All fields are required!</p>";
            }
        }
    } catch (PDOException $e) {
        $message = "<p style='color:red;'>Database connection failed: " . $e->getMessage() . "</p>";
    }
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
