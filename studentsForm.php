<?php

    $current_name = "";
    $current_address = "";
    $current_student_id = "";
    $current_department = "";
    $message = "";
    if(!isset($_GET['student']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        include('./backend/addingStudent.php');
    }
    if(isset($_GET['student']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        include('./backend/update_student_information.php');
    }

    if(isset($_GET['student'])){
        //display current student information if task is to update
        include("./backend/database_information.php");
        $edit_item = $_GET['student'];
        $stmt = $pdo->prepare("SELECT full_name, address, department, student_id_number
                                FROM students
                                WHERE id = :student_id LIMIT 1");
        $stmt->execute([
            'student_id' => $edit_item
        ]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        if($student){
            $current_name = $student['full_name'];
            $current_address =  $student['address'];
            $current_student_id = $student['student_id_number'];
            $current_department = $student['department'];
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/general.css">
    <link rel="stylesheet" href="./style/form.css">
    
    <!--Remix Icon Cdn link (For ICONS)-->
    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
        rel="stylesheet"
    />
    <title>CSUA-Lib Student Form</title>
</head>
<body>
    <section id="formSection">
        <form action="<?php 
                echo htmlspecialchars($_SERVER['PHP_SELF']) . 
                (isset($_GET['student']) ? '?student=' . $_GET['student'] : '')?>" 
                method="POST"
                id="form">
            <div style="display: flex; margin: 0 0 10px 0">
                <a href="./index.php" style="text-decoration: none;color: #191919;">
                    <i class="ri-arrow-left-line" style="font-size: 1.3rem;"></i>
                </a>
                <h1 style="flex: 1; text-align:center;">Student Information</h1>
            </div>
            <p class="light-text" style="text-align: center;margin: 0 0 30px 20px;  ">
                Please fill in the required details below.
            </p>

            <h2>Personal Information</h2>
            <div class="inputBox">
                <input type="text" name="full_name" id="full_name" placeholder=" " value="<?= $current_name?>" required>
                <label for="full_name">Full Name:</label>
            </div>
            <div class="inputBox">
                <input 
                    type="text"
                    name="address"
                    id="address"
                    placeholder=" "
                    value="<?= $current_address ?>"
                    required>
                <label for="Adress">Address:</label>
            </div>

            <h2>Academic Information</h2>
            <div class="inputBox">
                <input 
                    type="text"
                    name="student_id_number"
                    id="student_id_number"
                    placeholder=" "
                    value="<?= $current_student_id ?>"
                    required>
                <label for="student_id_number">Student ID:</label>

            </div>

            <div class="dropDown">
                <label for="department">Department</label>
                <select 
                    name="department"
                    id="department"
                    
                    required>
                    <option value="">Select Department...</option>
                    <option value="College of Information and Computing Sciences"
                        <?php if($current_department == 'College of Information and Computing Sciences') echo 'selected' ?>
                        >College of Information and Computing Sciences</option>
                    <option value="College of Teaching Education"
                        <?php if($current_department == 'College of Teaching Education') echo 'selected' ?>
                        >College of Teaching Education</option>
                    <option value="College of Fisheries and Aquatic Sciences"
                        <?php if($current_department == 'College of Fisheries and Aquatic Sciences') echo 'selected' ?>
                        >College of Fisheries and Aquatic Sciences</option>
                    <option value="College of Criminal Justice Education"
                        <?php if($current_department == 'College of Criminal Justice Education') echo 'selected' ?>
                        >College of Criminal Justice Education</option>
                    <option value="College of Human Management"
                        <?php if($current_department == 'College of Human Management') echo 'selected' ?>
                        >College of Hospitality Management</option>
                    <option value="College of Business, Economics and Accountancy"
                        <?php if($current_department == 'College of Business, Economics and Accountancy') echo 'selected' ?>
                        >College of Business, Economics and Accountancy</option>
                    <option value="College of Industrial Technology"
                        <?php if($current_department == 'College of Industrial Technology') echo 'selected' ?>
                        >College of Industrial Technology</option>
                </select>
            </div>
            <div class="errorMessage">
                <p style="color: red;"><?= $message ?></p>
            </div>
            <button type="submit" class="submitBtn"><?php echo isset($_GET['student']) ? "Update Student" : "Add Student"?></button>
        </form>
    </section>
</body>
</html>
