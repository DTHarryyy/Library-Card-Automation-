<?php
// Local settings
$host = "localhost";
$dbname = "librarycardusers";
$username = "root";
$password = "";

// InfinityFree settings
$if_host = "sql213.infinityfree.com";
$if_dbname = "if0_39844114_csu_library_card_generator";
$if_username = "if0_39844114";
$if_password = "harry070625";

// Switch based on environment
$env = "production"; // change to "production" when deploying

if($env == "local"){
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
}else{
    $pdo = new PDO("mysql:host=$if_host;dbname=$if_dbname", $if_username, $if_password);
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
