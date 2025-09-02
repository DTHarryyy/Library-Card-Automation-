<?php 
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/general.css">
    <link rel="stylesheet" href="./style/header.css">
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
             <button class="btnType2 buttons">Print</button>
           </form>
        </div>
    </header>
    <section>
        <?php 
            include('./pages/users.php');
        ?>  
    </section>
</body>
</html>