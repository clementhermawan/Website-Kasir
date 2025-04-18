<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'atasan') {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$error = $success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Username sudah terdaftar.";
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')");
        $success = "User berhasil ditambahkan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah User</title>
    <link rel="stylesheet" href="user_style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="content">
    <h2>Tambah User Baru</h2>

    <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
    <?php if ($success): ?><div class="success"><?= $success ?></div><?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="role" required>
                <option value="pegawai">Pegawai</option>
                <option value="atasan">Atasan</option>
            </select>
        </div>
        <input type="submit" value="Tambah">
        <a href="kelola_user.php" class="back-btn">🔙 Kembali</a>
    </form>
</div>
</body>
</html>
