<?php
// koneksi ke database
include 'koneksi.php';

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id_barang = mysqli_real_escape_string($koneksi, $_POST['id_barang']);
    $nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $stok = mysqli_real_escape_string($koneksi, $_POST['stok']);

    // Validasi input
    if (empty($nama_barang) || empty($harga) || empty($stok)) {
        $error = "Semua field harus diisi!";
    } else {
        // Query untuk memperbarui data barang berdasarkan ID
        $query = "UPDATE barang SET nama_barang = '$nama_barang', harga = '$harga', stok = '$stok' WHERE id_barang = $id_barang";
        
        if (mysqli_query($koneksi, $query)) {
            $success = "Barang berhasil diperbarui!";
            header("Location: kelola_barang.php"); // Redirect ke halaman kelola_barang.php setelah sukses
            exit;
        } else {
            $error = "Terjadi kesalahan saat memperbarui barang. Coba lagi!";
        }
    }
} else {
    // Redirect ke halaman kelola_barang.php jika akses langsung ke halaman ini tanpa POST
    header("Location: kelola_barang.php");
    exit;
}
?>
