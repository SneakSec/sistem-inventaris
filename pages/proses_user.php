<?php
session_start();
include '../config/database.php';

// Pastikan hanya admin
if($_SESSION['role'] != 'admin'){
    header("location: ../index.php");
    exit;
}

// --- 1. LOGIKA TAMBAH USER ---
if(isset($_POST['aksi']) && $_POST['aksi'] == 'tambah'){
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $role     = $_POST['role'];

    $cek = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if(mysqli_num_rows($cek) > 0){
        echo "<script>alert('GAGAL! Username sudah dipakai.'); window.location='users.php';</script>";
        exit;
    }

    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Berhasil menambah user baru!'); window.location='users.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// --- 2. LOGIKA RESET PASSWORD (BARU) ---
elseif(isset($_POST['aksi']) && $_POST['aksi'] == 'reset'){
    $id            = $_POST['id'];
    $password_baru = $_POST['password_baru']; // Plain text sesuai request

    // Update password di database berdasarkan ID
    $query = "UPDATE users SET password = '$password_baru' WHERE id = '$id'";

    if(mysqli_query($conn, $query)){
        echo "<script>alert('SUKSES! Password user berhasil direset.'); window.location='users.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// --- 3. LOGIKA HAPUS USER ---
elseif(isset($_GET['aksi']) && $_GET['aksi'] == 'hapus'){
    $id = $_GET['id'];
    $cek_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT username FROM users WHERE id = '$id'"));
    
    if($cek_user['username'] == $_SESSION['username']){
         echo "<script>alert('ANDA TIDAK BISA MENGHAPUS AKUN SENDIRI!'); window.location='users.php';</script>";
         exit;
    }

    $query = "DELETE FROM users WHERE id = '$id'";
    if(mysqli_query($conn, $query)){
        echo "<script>alert('User berhasil dihapus.'); window.location='users.php';</script>";
    }
}
?>