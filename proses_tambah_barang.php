<?php
// koneksi ke database
include 'koneksi.php';

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $stok = mysqli_real_escape_string($koneksi, $_POST['stok']);

    // Validasi input
    if (empty($nama_barang) || empty($harga) || empty($stok)) {
        $error = "Semua field harus diisi!";
    } else {
        // Query untuk memasukkan data ke tabel barang
        $query = "INSERT INTO barang (nama_barang, harga, stok) VALUES ('$nama_barang', '$harga', '$stok')";
        
        if (mysqli_query($koneksi, $query)) {
            $success = "Barang berhasil ditambahkan!";
            header("Location: kelola_barang.php"); // Redirect ke halaman kelola_barang.php setelah sukses
            exit;
        } else {
            $error = "Terjadi kesalahan saat menambahkan barang. Coba lagi!";
        }
    }
}
?>

<!-- HTML Form untuk menambah barang (gunakan bagian form dari halaman tambah barang yang sudah dibuat sebelumnya) -->
