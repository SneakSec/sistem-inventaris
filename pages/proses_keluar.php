<?php
include '../config/database.php';

// Ambil data dari form
$barang_id = $_POST['barang_id'];
$jumlah    = $_POST['jumlah'];
$tanggal   = $_POST['tanggal'];
$penerima  = $_POST['penerima'];

// --- TAHAP 1: CEK KETERSEDIAAN STOK ---
// Ambil data stok barang yang dipilih dari database
$cek_stok = mysqli_query($conn, "SELECT stok, nama_barang FROM barang WHERE id = '$barang_id'");
$data = mysqli_fetch_assoc($cek_stok);

$stok_sekarang = $data['stok'];
$nama_barang   = $data['nama_barang'];

// Logika Validasi:
// Jika jumlah yang diminta LEBIH BESAR dari stok yang ada
if($jumlah > $stok_sekarang) {
    // Tampilkan pesan error dan batalkan proses
    echo "<script>
            alert('GAGAL! Stok barang $nama_barang tidak cukup. Sisa stok: $stok_sekarang');
            window.location='barang_keluar.php';
          </script>";
    exit; // Stop codingan disini
}

// --- TAHAP 2: PROSES SIMPAN (Jika stok cukup) ---

// A. Simpan ke riwayat barang_keluar
$query1 = "INSERT INTO barang_keluar (barang_id, jumlah, tanggal, penerima) 
           VALUES ('$barang_id', '$jumlah', '$tanggal', '$penerima')";

// B. Kurangi stok di tabel barang
$query2 = "UPDATE barang SET stok = stok - $jumlah WHERE id = '$barang_id'";

// Jalankan query
if(mysqli_query($conn, $query1) && mysqli_query($conn, $query2)){
    echo "<script>
            alert('Berhasil! Barang telah dikeluarkan.');
            window.location='barang_keluar.php';
          </script>";
} else {
    echo "Gagal: " . mysqli_error($conn);
}
?>