<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'pegawai') {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

// Ambil semua barang, suplier, dan pembeli dari database
$barang_list = mysqli_query($koneksi, "SELECT * FROM barang");
$suplier_list = mysqli_query($koneksi, "SELECT * FROM suplier");
$pembeli_list = mysqli_query($koneksi, "SELECT * FROM pembeli");

$harga = $diskon = $nilai_diskon = $total_harga = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barang_id = intval($_POST['barang']);
    $pembeli_id = intval($_POST['pembeli']);
    $suplier_id = intval($_POST['suplier']);
    $diskon = floatval($_POST['diskon']);

    $get_barang = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang = $barang_id");
    $data_barang = mysqli_fetch_assoc($get_barang);
    $harga = floatval($data_barang['harga']);

    if ($harga <= 0) {
        $error = "Harga tidak valid.";
    } elseif ($diskon < 0 || $diskon > 100) {
        $error = "Diskon harus di antara 0 hingga 100.";
    } else {
        $nilai_diskon = $harga * ($diskon / 100);
        $total_harga = $harga - $nilai_diskon;

        // Simpan ke tabel pembelian, termasuk harga sebelum diskon
        $query = "INSERT INTO pembelian (id_barang, id_pembeli, total_harga, harga_sebelum_diskon, diskon, tanggal, id_suplier) 
        VALUES ($barang_id, $pembeli_id, $total_harga, $harga, $diskon, NOW(), $suplier_id)";
        mysqli_query($koneksi, $query);
        $last_id = mysqli_insert_id($koneksi);

        header("Location: cetak_struk.php?id=$last_id");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Pegawai</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            margin: 0;
            background: #f7f9fc;
            font-family: 'Segoe UI', sans-serif;
        }


        .logout-btn {
            background: #e74c3c;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            transition: 0.3s ease;
        }

        .logout-btn:hover {
            background: #c0392b;
        }

        .content {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #34495e;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }

        input[type="number"],
        select {
            width: 100%;
            padding: 14px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 15px;
            background: white;
            box-sizing: border-box;
            transition: border 0.3s;
        }

        input[type="number"]:focus,
        select:focus {
            border-color: #2980b9;
            outline: none;
        }

        input[type="submit"] {
            background: #2980b9;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background: #1c5980;
        }

        .result {
            margin-top: 25px;
            padding: 20px;
            background: #ecf9f1;
            border-left: 6px solid #2ecc71;
            border-radius: 10px;
            color: #2e7d32;
        }

        .error {
            background: #ffe0e0;
            color: #c0392b;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .navbar {
            background: #34495e;
            padding: 10px 20px;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        .navbar li {
            margin: 0 15px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            display: inline-block;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .navbar a:hover {
            background: #2c3e50;
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <ul>
            <li><a href="dashboard_pegawai.php">🏠 Dashboard</a></li>
            <li><a href="riwayat_pembelian.php">📜 Riwayat Pembelian</a></li>
            <li><a href="logout.php">🚪 Logout</a></li>
        </ul>
    </nav>


    <div class="content">
        <h2>Hitung Diskon Barang</h2>

        <?php if (!empty($error)) : ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="barang">Pilih Barang</label>
                <select name="barang" id="barang" required onchange="updateHarga()">
                    <option value="">-- Pilih Barang --</option>
                    <?php mysqli_data_seek($barang_list, 0);
                    while ($b = mysqli_fetch_assoc($barang_list)) : ?>
                        <option value="<?= $b['id_barang'] ?>" data-harga="<?= $b['harga'] ?>" <?= (isset($_POST['barang']) && $_POST['barang'] == $b['id_barang']) ? 'selected' : '' ?>>
                            <?= $b['nama_barang'] ?> (Rp <?= number_format($b['harga']) ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="harga">Harga Barang</label>
                <input type="number" step="0.01" id="harga" readonly value="<?= htmlspecialchars($harga) ?>">
            </div>

            <div class="form-group">
                <label for="diskon">Diskon (%)</label>
                <input type="number" step="0.01" name="diskon" id="diskon" required value="<?= htmlspecialchars($diskon) ?>">
            </div>

            <div class="form-group">
                <label for="pembeli">Nama Pembeli</label>
                <select name="pembeli" id="pembeli" required>
                    <option value="">-- Pilih Pembeli --</option>
                    <?php while ($p = mysqli_fetch_assoc($pembeli_list)) : ?>
                        <option value="<?= $p['id'] ?>" <?= (isset($_POST['pembeli']) && $_POST['pembeli'] == $p['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p['nama']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="suplier">Nama Suplier</label>
                <select name="suplier" id="suplier" required>
                    <option value="">-- Pilih Suplier --</option>
                    <?php while ($s = mysqli_fetch_assoc($suplier_list)) : ?>
                        <option value="<?= $s['id'] ?>" <?= (isset($_POST['suplier']) && $_POST['suplier'] == $s['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($s['nama_suplier']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <input type="submit" value="Hitung & Simpan">
        </form>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error)) : ?>
            <div class="result">
                <p><strong>Nilai Diskon:</strong> Rp <?= number_format($nilai_diskon, 2, ',', '.') ?></p>
                <p><strong>Total Setelah Diskon:</strong> Rp <?= number_format($total_harga, 2, ',', '.') ?></p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function updateHarga() {
            const select = document.getElementById('barang');
            const selected = select.options[select.selectedIndex];
            const harga = selected.getAttribute('data-harga');
            document.getElementById('harga').value = harga;
        }

        // Atur harga saat reload jika barang sudah dipilih
        window.onload = function() {
            if (document.getElementById('barang').value !== "") {
                updateHarga();
            }
        };
    </script>

</body>

</html>