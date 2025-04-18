<head>
    <style>
        header {
            background: #2c3e50;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        header h2 {
            margin: 0;
            font-size: 20px;
            color: white;
        }

        nav a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .logout-btn {
            background: #e74c3c;
            padding: 6px 14px;
            border-radius: 6px;
            margin-left: 20px;
        }
    </style>
</head>
<header>
    <div class="left">
        <h2>Dashboard Atasan</h2>
    </div>
    <nav class="right">
        <a href="dashboard_atasan.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="riwayat.php"><i class="fas fa-receipt"></i> Riwayat</a>
        <a href="kelola_user.php"><i class="fas fa-users"></i> Kelola User</a>
        <a href="kelola_barang.php"><i class="fas fa-cogs"></i> Kelola Barang</a>
        <a href="export_laporan.php"><i class="fas fa-file-export"></i> Export</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
</header>