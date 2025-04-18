<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'atasan') {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

// Ambil semua data barang dari database
$barang_list = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang");

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Barang</title>
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
        <h2>Kelola Barang</h2>
        <a href="tambah_barang.php" class="btn add-btn">+ Tambah Barang</a>

        <table>
            <tr>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
            <?php while ($b = mysqli_fetch_assoc($barang_list)) : ?>
                <tr>
                    <td><?= htmlspecialchars($b['nama_barang']) ?></td>
                    <td>Rp <?= number_format($b['harga'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($b['stok']) ?></td>
                    <td>
                        <a href="edit_barang.php?id=<?= $b['id_barang'] ?>" class="btn edit-btn"><i class="fas fa-edit"></i></a>
                        <a href="hapus_barang.php?id=<?= $b['id_barang'] ?>" onclick="return confirm('Yakin ingin hapus?')" class="btn delete-btn"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

</body>

</html>
