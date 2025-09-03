<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Detect environment automatically
if ($_SERVER['HTTP_HOST'] == "csua-lib-card-generator.fwh.is") {
    // Production (InfinityFree)
    $host = "sql213.infinityfree.com";
    $dbname = "if0_39844114_csu_library_card_generator";
    $username = "if0_39844114";
    $password = "harry070625";
} else {
    // Local
    $host = "localhost";
    $dbname = "librarycardusers";
    $username = "root";
    $password = "";
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>