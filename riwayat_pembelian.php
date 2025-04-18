<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'pegawai') {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$query = "SELECT p.*, b.nama_barang 
          FROM pembelian p 
          JOIN barang b ON p.id_barang = b.id_barang 
          ORDER BY p.tanggal DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pembelian</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #0072ff;
            color: white;
        }

        tr:hover {
            background: #f1f1f1;
        }

        .btn-kembali {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 16px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }

        .btn-kembali:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>

    <h2>Riwayat Pembelian</h2>

    <table>
        <tr>
            <th>#</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Diskon (%)</th>
            <th>Total Bayar</th>
            <th>Tanggal</th>
        </tr>
        <?php $no = 1; while ($data = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($data['nama_barang']) ?></td>
                <td>Rp <?= number_format($data['harga'], 2, ',', '.') ?></td>
                <td><?= $data['diskon'] ?>%</td>
                <td>Rp <?= number_format($data['total_harga'], 2, ',', '.') ?></td>
                <td><?= date('d-m-Y H:i', strtotime($data['tanggal'])) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="dashboard_pegawai.php" class="btn-kembali">🔙 Kembali ke Dashboard</a>

</body>
</html>
