<?php
    session_start();
    include('./backend/database_information.php');
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $full_name = htmlspecialchars(trim($_POST['full_name']));
        $student_id_number = htmlspecialchars(trim($_POST['student_id_number']));
        $address = htmlspecialchars(trim($_POST['address']));
        $department = htmlspecialchars(trim($_POST['department']));
        $edit_item = $_GET['student'];
        if (!empty($full_name) && !empty($student_id_number) && !empty($department)) {
            $sql = "UPDATE students 
                    SET full_name = :full_name, 
                        address = :address, 
                        department = :department, 
                        student_id_number = :student_id_number
                    WHERE id = :id";
            $updateStmt = $pdo->prepare($sql);
            $params = [
                'full_name' => $full_name,
                'address' => $address,
                'department' => $department,
                'student_id_number' => $student_id_number,
                'id' => $edit_item
            ];

            if($updateStmt->execute($params)){
                header("Location: ./index.php");
            }
            
        } else {
            echo "<p style='color:red;'>All required fields must be filled!</p>";
    }
    }
?>