<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'atasan') {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$id_barang = intval($_GET['id']);

// Hapus barang berdasarkan ID
$query = "DELETE FROM barang WHERE id_barang = $id_barang";
if (mysqli_query($koneksi, $query)) {
    header("Location: kelola_barang.php");
    exit;
} else {
    echo "Terjadi kesalahan saat menghapus barang.";
}
?>
