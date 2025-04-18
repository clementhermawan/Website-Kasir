<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'atasan') {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$users = mysqli_query($koneksi, "SELECT * FROM users ORDER BY role, username");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 14px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background: #ecf0f1;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
        }

        .edit-btn {
            background: #3498db;
        }

        .delete-btn {
            background: #e74c3c;
        }

        .add-btn {
            background: #2ecc71;
            float: right;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2>Kelola Pegawai & Atasan</h2>
        <a href="tambah_user.php" class="btn add-btn">+ Tambah User</a>

        <table>
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Dibuat Pada</th>
                <th>Aksi</th>
            </tr>
            <?php while ($u = mysqli_fetch_assoc($users)) : ?>
                <tr>
                    <td><?= htmlspecialchars($u['username']) ?></td>
                    <td><?= htmlspecialchars($u['role']) ?></td>
                    <td><?= $u['created_at'] ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $u['id'] ?>" class="btn edit-btn"><i class="fas fa-edit"></i></a>
                        <a href="hapus_user.php?id=<?= $u['id'] ?>" onclick="return confirm('Yakin ingin hapus?')" class="btn delete-btn"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

</body>

</html>