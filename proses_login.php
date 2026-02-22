<?php
// 1. Mulai Session
session_start();

// 2. Panggil Koneksi Database
include 'config/database.php';

// 3. Tangkap Input
$username = $_POST['username'];
$password = $_POST['password']; 

// --- BAGIAN CEK LOGIN ---
// Kita pakai password biasa (tanpa md5) sesuai kondisi database kamu
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$query = mysqli_query($conn, $sql);

// Cek jika query error (untuk debugging)
if (!$query) {
    die("Error Database: " . mysqli_error($conn));
}

// 4. Hitung Jumlah Data yang Cocok
$cek = mysqli_num_rows($query);

if($cek > 0){
    // JIKA BENAR (Login Sukses)
    $data = mysqli_fetch_assoc($query);

    // Simpan Tiket (Session)
    $_SESSION['status']   = "login";
    $_SESSION['username'] = $username;
    
    // Simpan Role & Nama (Jika ada kolom role, jika tidak ada kita default 'admin')
    $_SESSION['role']     = isset($data['role']) ? $data['role'] : 'admin';
    $_SESSION['nama']     = isset($data['nama']) ? $data['nama'] : ucfirst($username);

    // Kirim ke Dashboard
    header("location: index.php");
} else {
    // JIKA SALAH (Login Gagal)
    header("location: login.php?pesan=gagal");
}
?>