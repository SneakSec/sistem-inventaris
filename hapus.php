<?php
session_start(); // Pastikan session dimulai
include 'config/database.php';

// --- CEK ROLE (PROTEKSI) ---
// Jika role BUKAN admin, tolak aksesnya!
if($_SESSION['role'] != 'admin'){
    echo "<script>
            alert('AKSES DITOLAK! Anda bukan Admin.');
            window.location='index.php';
          </script>";
    exit; // Stop kodingan
}


// Cek apakah ada ID di URL
if(isset($_GET['id'])){
    $id = $_GET['id'];

    // --- SOLUSI FOREIGN KEY (PEMBERSIHAN TOTAL) ---
    // Logika: Hapus Anak-anaknya dulu, baru Induknya.

    // 1. Hapus riwayat di tabel BARANG_MASUK
    $hapus_masuk = mysqli_query($conn, "DELETE FROM barang_masuk WHERE barang_id = '$id'");

    // 2. Hapus riwayat di tabel BARANG_KELUAR (Ini yang bikin error tadi)
    $hapus_keluar = mysqli_query($conn, "DELETE FROM barang_keluar WHERE barang_id = '$id'");

    // 3. Setelah bersih, baru hapus DATA BARANG utamanya
    $query = "DELETE FROM barang WHERE id = '$id'";

    if(mysqli_query($conn, $query)){
        // Jika berhasil, kembali ke index
        header("location: index.php?pesan=hapus");
    } else {
        echo "Gagal menghapus: " . mysqli_error($conn);
    }
} else {
    // Jika orang iseng buka file ini tanpa ID
    header("location: index.php");
}
?>