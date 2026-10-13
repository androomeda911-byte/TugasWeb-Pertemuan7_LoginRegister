<?php
require 'helpers.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?msg=login_required');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="card">
    <h2>🏠 Dashboard</h2>
    <p>Selamat datang, <strong><?= e($_SESSION['username']) ?></strong>!</p>
    <p>Email: <?= e($_SESSION['email']) ?></p>
    <a class="button" href="logout.php">🚪 Logout</a>
</main>
</body>
</html>