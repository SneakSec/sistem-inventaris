<?php
include 'config/database.php';

// Ambil data dari form
$id     = $_POST['id'];
$nama   = $_POST['nama_barang'];
$stok   = $_POST['stok'];
$satuan = $_POST['satuan'];

// Query Update
$query = "UPDATE barang SET 
            nama_barang = '$nama',
            stok = '$stok',
            satuan = '$satuan'
          WHERE id = '$id'";

// Eksekusi
if(mysqli_query($conn, $query)){
    header("location: index.php?pesan=update");
} else {
    echo "Gagal update data: " . mysqli_error($conn);
}
?>