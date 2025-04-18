<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'atasan') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM users WHERE id = $id");
header("Location: kelola_user.php");
exit;
?>
