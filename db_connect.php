<?php
// Konfigurasi database
$db_host = 'localhost';
$db_user = 'your_db_username'; // Change this to your MySQL username
$db_pass = 'your_db_password'; // Change this to your MySQL password
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
