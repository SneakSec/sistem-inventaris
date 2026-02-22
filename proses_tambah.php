<?php
include 'config/database.php';

// Ambil data dari form
$kode   = $_POST['kode_barang'];
$nama   = $_POST['nama_barang'];
$stok   = $_POST['stok'];
$satuan = $_POST['satuan'];

// --- VALIDASI DUPLIKAT ---
// 1. Cek Kode Barang
$cek_kode = mysqli_query($conn, "SELECT kode_barang FROM barang WHERE kode_barang = '$kode'");
if(mysqli_num_rows($cek_kode) > 0){
    header("location: tambah.php?pesan=duplikat_kode");
    exit;
}

// 2. Cek Nama Barang
$cek_nama = mysqli_query($conn, "SELECT nama_barang FROM barang WHERE nama_barang LIKE '$nama'");
if(mysqli_num_rows($cek_nama) > 0){
    header("location: tambah.php?pesan=duplikat_nama");
    exit;
}

// --- PROSES SIMPAN UTAMA ---
// Insert ke tabel master barang
$query_insert = "INSERT INTO barang (kode_barang, nama_barang, stok, satuan) 
                 VALUES ('$kode', '$nama', '$stok', '$satuan')";

if(mysqli_query($conn, $query_insert)){
    
    // --- FITUR OPSI B (AUTO RECORD) ---
    // Jika user mengisi stok awal (lebih dari 0), catat ke riwayat
    if($stok > 0) {
        
        // 1. Ambil ID barang yang barusan dibuat (Fungsi Penting!)
        $barang_id_baru = mysqli_insert_id($conn); 
        
        // 2. Siapkan data untuk riwayat
        $tanggal_sekarang = date('Y-m-d');
        $keterangan       = "Stok Awal (Inisialisasi Sistem)";
        
        // 3. Insert ke tabel barang_masuk
        $query_history = "INSERT INTO barang_masuk (barang_id, jumlah, tanggal, keterangan) 
                          VALUES ('$barang_id_baru', '$stok', '$tanggal_sekarang', '$keterangan')";
        
        mysqli_query($conn, $query_history);
    }

    // Kembali ke Dashboard
    header("location: index.php?pesan=berhasil");

} else {
    echo "Error Sistem: " . mysqli_error($conn);
}
?>