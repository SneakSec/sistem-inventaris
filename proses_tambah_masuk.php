<?php
include '../config/database.php';

// Ambil data dari form
$id_barang = $_POST['barang_id'];
$jumlah    = $_POST['jumlah'];
$tanggal   = $_POST['tanggal'];
$ket       = $_POST['keterangan'];

// 1. Query Simpan ke Riwayat Barang Masuk
$query1 = "INSERT INTO barang_masuk (barang_id, jumlah, tanggal, keterangan) 
           VALUES ('$id_barang', '$jumlah', '$tanggal', '$ket')";

// 2. Query Update Stok di Tabel Barang
$query2 = "UPDATE barang SET stok = stok + $jumlah WHERE id = '$id_barang'";

// Eksekusi Kedua Query
if(mysqli_query($conn, $query1) && mysqli_query($conn, $query2)){
    header("location: ../index.php?page=barang_masuk&pesan=berhasil");
} else {
    echo "Gagal: " . mysqli_error($conn);
}
?>