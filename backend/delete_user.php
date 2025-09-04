<?php
header("Content-Type: application/json");

include("./database_information.php"); // adjust path if needed

// Read raw POST data
$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['student'])) {
    echo json_encode(["success" => false, "message" => "No student ID provided"]);
    exit;
}

$studentId = $input['student'];

try {
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
    $stmt->execute(['id' => $studentId]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => true, "message" => "Student deleted successfully"]);
        
    } else {
        echo json_encode(["success" => false, "message" => "Student not found"]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
