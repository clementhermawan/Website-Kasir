<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'pegawai') {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

// Mengambil id_pembelian dari URL
$id_pembelian = intval($_GET['id']);

// Mengambil data pembelian
$query = "SELECT p.*, s.nama_suplier, pb.nama as nama_pembeli 
          FROM pembelian p
          LEFT JOIN suplier s ON p.id_suplier = s.id
          LEFT JOIN pembeli pb ON p.id_pembeli = pb.id
          WHERE p.id_pembelian = $id_pembelian";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

// Debug: Menampilkan data pembelian
// var_dump($data); die();

// Mengambil detail pesanan
$query_pesanan = "SELECT pesanan.*, b.nama_barang, pesanan.jumlah, pesanan.harga_satuan
                  FROM pesanan 
                  JOIN barang b ON pesanan.id_barang = b.id_barang
                  WHERE pesanan.id_pembelian = $id_pembelian";
$pesanan_result = mysqli_query($koneksi, $query_pesanan);

// Menampilkan Struk Pembelian
$harga_sebelum_diskon = (float) $data['harga_sebelum_diskon'];  // Pastikan menjadi float
$diskon = (float) $data['diskon'];  // Pastikan menjadi float
$total_harga = (float) $data['total_harga'];  // Pastikan menjadi float

// Debug: Menampilkan nilai diskon
// echo "Diskon: " . $diskon . "%"; die();

// Hitung total harga setelah diskon
$harga_setelah_diskon = $harga_sebelum_diskon - ($harga_sebelum_diskon * $diskon / 100);

// Format angka dengan number_format
$harga_sebelum_diskon_format = number_format($harga_sebelum_diskon, 2, ',', '.');
$total_harga_format = number_format($total_harga, 2, ',', '.');

$pesanan_items = [];
while ($pesanan = mysqli_fetch_assoc($pesanan_result)) {
    $pesanan_items[] = $pesanan;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Struk</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            max-width: 400px;
            margin: 40px auto;
            background: #fff;
            padding: 20px;
            border: 1px dashed #999;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2, p {
            text-align: center;
        }

        .info, .items {
            margin-bottom: 20px;
        }

        .info p, .items p {
            margin: 4px 0;
        }

        .btn-cetak, .btn-kembali {
            display: block;
            margin: 10px auto;
            padding: 10px 16px;
            background: #2ecc71;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            width: 80%;
        }

        .btn-kembali {
            background: #3498db;
        }

        .btn-cetak:hover {
            background: #27ae60;
        }

        .btn-kembali:hover {
            background: #2980b9;
        }

        @media print {
            .btn-cetak, .btn-kembali {
                display: none;
            }
        }
    </style>
</head>
<body>

<h2>Kasir Online</h2>
<p><strong>Struk Pembelian</strong></p>
<hr>

<div class="info">
    <p><strong>Nama Pembeli:</strong> <?= htmlspecialchars($data['nama_pembeli']) ?? '-' ?></p>
    <p><strong>Nama Suplier:</strong> <?= htmlspecialchars($data['nama_suplier']) ?></p>
    <p><strong>Tanggal:</strong> <?= date('d-m-Y H:i', strtotime($data['tanggal'])) ?></p>
    <p><strong>Harga Sebelum Diskon:</strong> Rp <?= $harga_sebelum_diskon_format ?></p>
    <p><strong>Diskon:</strong> <?= $diskon ?>%</p>
    <p><strong>Total Bayar:</strong> Rp <?= $total_harga_format ?></p>
</div>

<div class="items">
    <p><strong>Detail Pesanan:</strong></p>
    <?php if (count($pesanan_items) > 0): ?>
        <?php foreach ($pesanan_items as $item): ?>
            <p><?= htmlspecialchars($item['nama_barang']) ?> x <?= $item['jumlah'] ?> @ Rp <?= number_format($item['harga_satuan'], 2, ',', '.') ?></p>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Tidak ada item dalam pesanan.</p>
    <?php endif; ?>
</div>

<hr>
<p>Terima kasih atas pembelian Anda 🙏</p>

<button class="btn-cetak" onclick="window.print()">🖨️ Cetak Struk</button>
<a href="dashboard_pegawai.php" class="btn-kembali">🔙 Kembali ke Dashboard</a>

</body>
</html>
