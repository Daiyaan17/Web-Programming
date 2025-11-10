<?php
session_start();

// Hardcoded user credentials
$users = ['daiyaan' => '1234'];

// Handle logout
if (isset($_GET['logout'])) {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    session_destroy();
    header('Location: login.php');
    exit;
}

$error = '';
$enteredUser = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredUser = trim($_POST['username'] ?? '');
    $enteredPass = $_POST['password'] ?? '';

    if ($enteredUser === '' || $enteredPass === '') {
        $error = 'Please enter both username and password.';
    } elseif (isset($users[$enteredUser]) && hash_equals($users[$enteredUser], $enteredPass)) {
        $_SESSION['user'] = $enteredUser;
        header('Location: welcome.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login</title>
    <style>
        :root { --bg1:#89f7fe; --bg2:#66a6ff; --primary:#0078ff; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(120deg, var(--bg1), var(--bg2));
            color:#333; display:flex; justify-content:center; align-items:center;
            height:100vh; margin:0;
        }
        .card { background:#fff; padding:32px; border-radius:12px; width:340px;
                box-shadow:0 8px 24px rgba(0,0,0,.15); }
        h2 { margin:0 0 16px; color:var(--primary); text-align:center; }
        .field { margin-bottom:12px; }
        label { display:block; font-size:14px; margin-bottom:6px; }
        input { width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:8px; }
        button { width:100%; padding:10px 12px; border:0; border-radius:8px;
                 background:var(--primary); color:#fff; font-weight:bold; cursor:pointer; }
        .msg { margin-bottom:12px; padding:10px 12px; border-radius:8px; font-size:14px;
               background:#ffe6e6; color:#a40000; border:1px solid #ffb3b3; }
        .hint { font-size:12px; color:#777; text-align:center; margin-top:8px; }
        .logout { text-align:center; margin-top:12px; }
        .logout a { color: var(--primary); text-decoration:none; font-size:12px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Login</h2>

        <?php if ($error): ?>
            <div class="msg"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="field">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" required
                       value="<?php echo htmlspecialchars($enteredUser, ENT_QUOTES, 'UTF-8'); ?>"/>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required />
            </div>
            <button type="submit">Sign In</button>
        </form>
        <div class="hint"></div>
        <?php if (!empty($_SESSION['user'])): ?>
            <div class="logout"><a href="?logout=1">Logout</a></div>
        <?php endif; ?>
    </div>
</body>
</html>
