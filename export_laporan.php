<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'atasan') {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

$query = "SELECT p.*, b.nama_barang 
          FROM pembelian p 
          JOIN barang b ON p.id_barang = b.id_barang 
          WHERE MONTH(p.tanggal) = $bulan AND YEAR(p.tanggal) = $tahun 
          ORDER BY p.tanggal DESC";
$result = mysqli_query($koneksi, $query);

if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    // Mengatur Header untuk CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="laporan_pembelian.csv"');

    $output = fopen('php://output', 'w');
    
    // Menulis header CSV
    fputcsv($output, ['No', 'Tanggal', 'Barang', 'Harga', 'Diskon', 'Total']);

    // Menulis data dari database ke CSV
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, [
            $no++, 
            date('d-m-Y H:i', strtotime($row['tanggal'])), 
            $row['nama_barang'], 
            'Rp ' . number_format($row['harga'], 0, ',', '.'), 
            $row['diskon'] . '%', 
            'Rp ' . number_format($row['total_harga'], 0, ',', '.')
        ]);
    }

    fclose($output);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Export Laporan</title>
    <link rel="stylesheet" href="user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        .filter-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-form select,
        .filter-form button,
        .export-btn {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .export-btn {
            background-color: #3498db;
            color: white;
            text-decoration: none;
            transition: 0.3s ease;
        }

        .export-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="content">
        <h2>Laporan Pembelian - <?= date('F', mktime(0, 0, 0, $bulan, 1)) ?> <?= $tahun ?></h2>

        <form method="get" class="filter-form">
            <label for="bulan">Bulan:</label>
            <select name="bulan" id="bulan">
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    $selected = ($i == $bulan) ? 'selected' : '';
                    echo "<option value='$i' $selected>" . date('F', mktime(0, 0, 0, $i, 1)) . "</option>";
                }
                ?>
            </select>

            <label for="tahun">Tahun:</label>
            <select name="tahun" id="tahun">
                <?php
                for ($t = 2022; $t <= date('Y'); $t++) {
                    $selected = ($t == $tahun) ? 'selected' : '';
                    echo "<option value='$t' $selected>$t</option>";
                }
                ?>
            </select>

            <button type="submit">Tampilkan</button>
            <a href="export_laporan.php?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>&export=csv" class="export-btn">Export to CSV</a>
        </form>

       

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Barang</th>
                    <th>Harga</th>
                    <th>Diskon</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $grand_total = 0;
                while ($row = mysqli_fetch_assoc($result)) :
                    $grand_total += $row['total_harga'];
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($row['tanggal'])) ?></td>
                        <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td><?= $row['diskon'] ?>%</td>
                        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" style="text-align: right;">Total Pendapatan:</th>
                    <th>Rp <?= number_format($grand_total, 0, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>
    </div>

</body>

</html>
