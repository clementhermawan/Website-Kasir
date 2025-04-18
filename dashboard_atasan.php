<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'atasan') {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

$total_barang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM barang"))['total'];
$total_pembelian = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pembelian"))['total'];
$total_pendapatan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(total_harga) as total FROM pembelian WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'"))['total'] ?? 0;

$pendapatan_per_bulan = mysqli_query($koneksi, "
    SELECT MONTH(tanggal) as bulan, SUM(total_harga) as total 
    FROM pembelian 
    WHERE YEAR(tanggal) = '$tahun'
    GROUP BY MONTH(tanggal)
");
$data_chart = [];
while ($row = mysqli_fetch_assoc($pendapatan_per_bulan)) {
    $data_chart[(int)$row['bulan']] = (float)$row['total'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Atasan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f2f6fc;
        }
        .navbar {
            background: #2c3e50;
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 { margin: 0; font-size: 22px; }
        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
            padding: 10px 16px;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .nav-links a:hover { background-color: #1a252f; }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            flex: 1 1 280px;
            background: white;
            border-radius: 16px;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            transition: transform 0.3s;
        }
        .card:hover { transform: translateY(-5px); }
        .card h3 { margin: 10px 0 5px; font-size: 20px; color: #2c3e50; }
        .card p { font-size: 28px; font-weight: bold; color: #3498db; }
        .icon { font-size: 40px; margin-bottom: 10px; color: #2980b9; }
        .filter {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 30px 0;
        }
        .filter select {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        .btn-export {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            text-align: center;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
<div class="navbar">
    <h1>📊 Dashboard Atasan</h1>
    <div class="nav-links">
        <a href="dashboard_atasan.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="riwayat.php"><i class="fas fa-receipt"></i> Riwayat</a>
        <a href="kelola_user.php"><i class="fas fa-users"></i> Kelola User</a>
        <a href="kelola_barang.php"><i class="fas fa-cogs"></i> Kelola Barang</a>
        <a href="export_laporan.php"><i class="fas fa-file-export"></i> Export</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<div class="container">
    <div class="filter">
        <form method="get">
            <select name="bulan">
                <?php for ($i = 1; $i <= 12; $i++) : ?>
                    <option value="<?= $i ?>" <?= ($i == $bulan) ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $i, 10)) ?></option>
                <?php endfor; ?>
            </select>
            <select name="tahun">
                <?php for ($y = date('Y'); $y >= 2020; $y--) : ?>
                    <option value="<?= $y ?>" <?= ($y == $tahun) ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit">Tampilkan</button>
        </form>
    </div>

    <div class="cards">
        <div class="card">
            <div class="icon"><i class="fas fa-boxes"></i></div>
            <h3>Total Barang</h3>
            <p><?= $total_barang ?></p>
        </div>
        <div class="card">
            <div class="icon"><i class="fas fa-shopping-cart"></i></div>
            <h3>Total Pembelian</h3>
            <p><?= $total_pembelian ?></p>
        </div>
        <div class="card">
            <div class="icon"><i class="fas fa-coins"></i></div>
            <h3>Pendapatan <?= date('F', mktime(0,0,0,$bulan,1)) ?> <?= $tahun ?></h3>
            <p>Rp <?= number_format($total_pendapatan, 2, ',', '.') ?></p>
        </div>
    </div>

    <canvas id="chartPendapatan" style="margin-top: 40px;"></canvas>

    <a href="export_laporan.php?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="btn-export">
        <i class="fas fa-download"></i> Export PDF / Excel
    </a>
</div>

<script>
    const ctx = document.getElementById('chartPendapatan').getContext('2d');
    const data = {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [{
            label: 'Pendapatan Bulanan (<?= $tahun ?>)',
            data: [
                <?= isset($data_chart[1]) ? $data_chart[1] : 0 ?>,
                <?= isset($data_chart[2]) ? $data_chart[2] : 0 ?>,
                <?= isset($data_chart[3]) ? $data_chart[3] : 0 ?>,
                <?= isset($data_chart[4]) ? $data_chart[4] : 0 ?>,
                <?= isset($data_chart[5]) ? $data_chart[5] : 0 ?>,
                <?= isset($data_chart[6]) ? $data_chart[6] : 0 ?>,
                <?= isset($data_chart[7]) ? $data_chart[7] : 0 ?>,
                <?= isset($data_chart[8]) ? $data_chart[8] : 0 ?>,
                <?= isset($data_chart[9]) ? $data_chart[9] : 0 ?>,
                <?= isset($data_chart[10]) ? $data_chart[10] : 0 ?>,
                <?= isset($data_chart[11]) ? $data_chart[11] : 0 ?>,
                <?= isset($data_chart[12]) ? $data_chart[12] : 0 ?>
            ],
            backgroundColor: '#3498db',
            borderRadius: 8
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Grafik Pendapatan Bulanan'
                }
            }
        },
    };

    new Chart(ctx, config);
</script>
</body>
</html>
