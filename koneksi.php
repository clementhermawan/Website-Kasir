<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "kasir_online";

$koneksi = new mysqli($host, $user, $pass, $db);

if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}
?>
