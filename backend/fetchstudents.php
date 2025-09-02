<?php
include("./backend/database_information.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$stmt = $pdo->query("SELECT full_name, student_id_number, department FROM students");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
