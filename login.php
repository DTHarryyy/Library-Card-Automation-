<?php
session_start();

// Database connection
include('./backend/database_information.php');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle login
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Check if user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $user]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Verify password
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: /library/");
            exit();
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/general.css">
    <title>Document</title>

    <style>
        body { font-family: Arial, sans-serif; }
        .login-container {
            width: 300px; margin: 80px auto; padding: 20px;
            border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 0 5px #aaa;
        }
        input { width: 100%; padding: 10px; margin: 8px 0; }
        button { width: 100%; padding: 10px; background: #4CAF50; color: white; border: none; }
        .error { color: red; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="login-container">
    <h2>Login</h2>
    <?php if ($message): ?>
        <p class="error"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Enter Username" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
