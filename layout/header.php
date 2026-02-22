<?php
session_start();

// 1. Cek Login Standar
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){
    header("location: " . $base_url . "login.php?pesan=belum_login");
    exit;
}

// --- 2. LOGIKA AUTO LOGOUT (30 MENIT) ---
$waktu_timeout = 30 * 60;

// Cek apakah ada rekaman waktu aktivitas terakhir?
if(isset($_SESSION['waktu_terakhir'])){
    $durasi_diam = time() - $_SESSION['waktu_terakhir'];

    // Jika durasi diam melebihi batas waktu
    if($durasi_diam > $waktu_timeout){
        session_unset();
        session_destroy();
        // Redirect ke login dengan pesan timeout
        header("location: " . $base_url . "login.php?pesan=timeout");
        exit;
    }
}

// Update waktu aktivitas terakhir menjadi SEKARANG
// Jadi setiap user klik menu/refresh, timer di-reset ke 0 lagi.
$_SESSION['waktu_terakhir'] = time();


// --- 3. KONEKSI DATABASE ---
// Cek file koneksi ada dimana (karena header dipanggil dari root dan folder pages)
if(file_exists('config/database.php')){ 
    include 'config/database.php'; 
} elseif(file_exists('../config/database.php')){ 
    include '../config/database.php'; 
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($judul) ? $judul : 'Sistem Inventaris'; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= $base_url; ?>assets/css/style.css"> 

</head>
<body>
<div class="d-flex">