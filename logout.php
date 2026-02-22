<?php
session_start();

// Hapus semua session
session_destroy();

// Tendang ke halaman login
header("location: login.php?pesan=logout");
?>