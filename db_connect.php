<?php
// Konfigurasi database
$db_host = '127.0.0.1:3306';
$db_user = 'root';
$db_pass = 'N28042006t';
$db_name = 'buku_tamu';

// Membuat koneksi
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, "utf8");
?>