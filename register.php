<?php
require 'helpers.php';

$error = '';
$nama = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nama === '' || $email === '' || $password === '') {
        $error = 'Semua field wajib diisi!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } elseif (findUserByEmail($email) !== null) {
        $error = 'Email sudah terdaftar!';
    } else {
        $users = loadUsers();
        $newId = $users ? max(array_column($users, 'id')) + 1 : 1;

        $users[] = [
            'id'         => $newId,
            'nama'       => $nama,
            'email'      => strtolower($email),
            'password'   => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if (saveUsers($users)) {
            header('Location: login.php?msg=registered');
            exit;
        }
        $error = 'Gagal menyimpan data.';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="card">
    <h2>📝 Registrasi</h2>

    <?php if ($error !== ''): ?>
        <p class="alert error"><?= e($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" value="<?= e($nama) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= e($email) ?>" required>

        <label>Password (min. 6 karakter)</label>
        <input type="password" name="password" minlength="6" required>

        <button type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login</a></p>
</main>
</body>
</html>