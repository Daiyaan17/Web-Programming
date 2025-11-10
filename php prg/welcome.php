<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(120deg, #89f7fe, #66a6ff);
            color:#333; display:flex; justify-content:center; align-items:center;
            height:100vh; margin:0;
        }
        .card {
            background:#fff; padding:30px; border-radius:10px; width:360px;
            box-shadow:0 8px 24px rgba(0,0,0,.15); text-align:center;
        }
        h2 { color:#0078ff; margin:0 0 10px; }
        a { display:inline-block; margin-top:12px; color:#0078ff; text-decoration:none; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Login successful</h2>
        <p><?php echo 'Hello ' . htmlspecialchars($user, ENT_QUOTES, 'UTF-8') . ', successfully logged in.'; ?></p>
        <a href="login.php?logout=1">Logout</a>
    </div>
</body>
</html>
