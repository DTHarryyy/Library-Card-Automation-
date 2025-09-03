<?php
    // session_start();
    include("./backend/database_information.php");
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT full_name,address, student_id_number, department FROM students WHERE added_by_user_id = :user_id ");
    $stmt->execute(
        ['user_id' => $user_id]
    );
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
