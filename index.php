<?php 
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
    }
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/general.css">
    <link rel="stylesheet" href="./style/header.css">
    <link rel="stylesheet" href="./style/table.css">

    <title>Csua-Library</title>
</head>
<body>
    <header id="homeHeader">
        <div class="logo">
           <img src="../library/assets/images/csulogo.png" alt=""> 
           <img src="../library/assets/images/csulogo.png" alt=""> 
           <img src="../library/assets/images/csulogo.png" alt=""> 
        </div>
        <h1>Cagayan State University Library</h1>
        <div class="btns" style="display: flex;gap:10px;">
            <a href="./studentsForm.php"  class="btnType1 buttons">Add User</a>
           <form action="./generate.php" class="printBtn">
             <button class="btnType2 buttons" onclick="return confirm('Are you sure you want to download this file? ')">Print</button>
           </form>
        </div>
    </header>
    <section id="tableSection">
        <?php 
            include('./pages/students.php');
        ?>  
    </section>
</body>
</html>