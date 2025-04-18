<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah / Edit Barang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    /* Global Styles */
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f7fa;
        color: #333;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    h2 {
        margin-bottom: 20px;
        color: #2c3e50;
    }

    /* Header & Navbar */
    header {
        background-color: #2c3e50;
        color: white;
        padding: 20px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    header .left h2 {
        margin: 0;
        font-size: 1.4em;
    }

    header .right a {
        margin-left: 15px;
        padding: 10px 16px;
        background: #34495e;
        border-radius: 8px;
        font-size: 14px;
        transition: background 0.3s;
        color: #ecf0f1;
    }

    header .right a:hover {
        background: #1abc9c;
        color: white;
    }

    /* Container */
    .content {
        max-width: 700px;
        margin: 40px auto;
        padding: 30px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    /* Forms */
    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }

    input[type="text"],
    input[type="password"],
    input[type="number"],
    select {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #ccc;
        border-radius: 10px;
        font-size: 15px;
        background: white;
        box-sizing: border-box;
        transition: border 0.3s;
    }

    input[type="text"]:focus,
    input[type="password"]:focus,
    input[type="number"]:focus,
    select:focus {
        border-color: #3498db;
        outline: none;
    }

    input[type="submit"],
    button {
        background: #2980b9;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s;
    }

    input[type="submit"]:hover,
    button:hover {
        background: #2471a3;
    }

    /* Alerts */
    .success {
        background-color: #d4edda;
        color: #155724;
        padding: 14px;
        border-left: 6px solid #28a745;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .error {
        background-color: #f8d7da;
        color: #721c24;
        padding: 14px;
        border-left: 6px solid #dc3545;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    /* Table Styles */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table thead {
        background: #2980b9;
        color: white;
    }

    table th, table td {
        padding: 12px 14px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table tr:hover {
        background-color: #f1f1f1;
    }

    .action-btn {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        margin-right: 6px;
        color: white;
        text-decoration: none;
    }

    .edit-btn {
        background-color: #f39c12;
    }

    .delete-btn {
        background-color: #e74c3c;
    }

    .add-btn {
        background-color: #27ae60;
    }

    .back-btn {
        display: inline-block;
        background-color: #bdc3c7;
        color: #2c3e50;
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: bold;
        transition: 0.3s;
        text-decoration: none;
    }

    .back-btn:hover {
        background-color: #95a5a6;
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        header {
            flex-direction: column;
            align-items: flex-start;
        }

        header .right a {
            margin: 8px 0;
        }

        .content {
            margin: 20px;
            padding: 20px;
        }
    }
</style>

</head>

<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>


    <!-- Content -->
    <div class="content">
        <h2>Tambah Barang</h2>

        <!-- Success or Error Messages -->
        <?php if (!empty($error)) : ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php elseif (!empty($success)) : ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <!-- Form for Adding/Editing Barang -->
        <form method="POST" action="proses_tambah_barang.php">
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang" required value="<?= isset($barang) ? htmlspecialchars($barang['nama_barang']) : '' ?>">
            </div>

            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" step="0.01" id="harga" name="harga" required value="<?= isset($barang) ? htmlspecialchars($barang['harga']) : '' ?>">
            </div>

            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" id="stok" name="stok" required value="<?= isset($barang) ? htmlspecialchars($barang['stok']) : '' ?>">
            </div>

            <div class="btn-group">
                <a href="kelola_barang.php" class="btn back-btn">Kembali</a>
                <input type="submit" class="btn save-btn" value="Simpan Barang">
            </div>
        </form>
    </div>
</body>

</html>
