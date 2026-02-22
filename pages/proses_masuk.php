<?php
include '../config/database.php';

// Ambil data dari form
$barang_id  = $_POST['barang_id'];
$jumlah     = $_POST['jumlah'];
$tanggal    = $_POST['tanggal'];
$keterangan = $_POST['keterangan'];

// VALIDASI: Pastikan jumlah tidak negatif/nol
if($jumlah <= 0) {
    echo "<script>alert('Jumlah barang tidak boleh kosong!'); window.location='barang_masuk.php';</script>";
    exit;
}

// 1. Simpan ke tabel riwayat (barang_masuk)
$query1 = "INSERT INTO barang_masuk (barang_id, jumlah, tanggal, keterangan) 
           VALUES ('$barang_id', '$jumlah', '$tanggal', '$keterangan')";

// 2. Update stok di tabel barang (Stok Lama + Jumlah Masuk)
$query2 = "UPDATE barang SET stok = stok + $jumlah WHERE id = '$barang_id'";

// Jalankan Kedua Query
if(mysqli_query($conn, $query1) && mysqli_query($conn, $query2)){
    // Jika sukses, kembali ke halaman barang masuk
    echo "<script>alert('Berhasil! Stok telah bertambah.'); window.location='barang_masuk.php';</script>";
} else {
    echo "Gagal: " . mysqli_error($conn);
}
?>