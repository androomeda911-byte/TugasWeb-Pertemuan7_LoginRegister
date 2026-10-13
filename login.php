<?php
require 'helpers.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$success = '';
$email = '';

if (($_GET['msg'] ?? '') === 'registered') {
    $success = 'Registrasi berhasil! Silakan login.';
} elseif (($_GET['msg'] ?? '') === 'logged_out') {
    $success = 'Anda berhasil logout.';
} elseif (($_GET['msg'] ?? '') === 'login_required') {
    $error = 'Silakan login terlebih dahulu.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = findUserByEmail($email);

    if ($user !== null && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['nama'];
        $_SESSION['email']    = $user['email'];

        header('Location: dashboard.php');
        exit;
    }
    $error = 'Email atau password salah!';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="card">
    <h2>🔐 Login</h2>

    <?php if ($success !== ''): ?>
        <p class="alert success"><?= e($success) ?></p>
    <?php endif; ?>
    <?php if ($error !== ''): ?>
        <p class="alert error"><?= e($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Email</label>
        <input type="email" name="email" value="<?= e($email) ?>" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
    <p>Belum punya akun? <a href="register.php">Daftar</a></p>
</main>
</body>
</html>