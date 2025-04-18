<?php
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = md5($_POST['password']); // sesuaikan dengan DB

$query = $koneksi->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");

if ($query->num_rows > 0) {
    $user = $query->fetch_assoc();
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] === 'atasan') {
        header("Location: dashboard_atasan.php");
    } else {
        header("Location: dashboard_pegawai.php");
    }
} else {
    header("Location: login.php?error=Username atau password salah");
}
?>
