<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_inventaris";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}

$base_url = "http://localhost/sistem_inventaris/"
?>