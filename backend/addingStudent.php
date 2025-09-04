<?php
    session_start();
    include('./backend/database_information.php');
     

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sanitize input
            $full_name = htmlspecialchars(trim($_POST['full_name']));
            $student_id_number = htmlspecialchars(trim($_POST['student_id_number']));
            $address = htmlspecialchars(trim($_POST['address']));
            $department = htmlspecialchars(trim($_POST['department']));
            $added_by_user_id = $_SESSION['user_id'];

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