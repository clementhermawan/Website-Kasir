<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'atasan') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id = $id"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $role = $_POST['role'];

    mysqli_query($koneksi, "UPDATE users SET username='$username', role='$role' WHERE id=$id");
    header("Location: kelola_user.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="user_style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="content">
    <h2>Edit User</h2>

    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required value="<?= $user['username'] ?>">
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="role">
                <option value="pegawai" <?= $user['role'] == 'pegawai' ? 'selected' : '' ?>>Pegawai</option>
                <option value="atasan" <?= $user['role'] == 'atasan' ? 'selected' : '' ?>>Atasan</option>
            </select>
        </div>
        <input type="submit" value="Simpan Perubahan">
        <a href="kelola_user.php" class="back-btn">🔙 Kembali</a>
    </form>
</div>
</body>
</html>
