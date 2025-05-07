<?php
// Script untuk memindahkan data dari file teks ke database
require_once 'db_connect.php';

$data_file = 'data_tamu.txt';

// Cek apakah file ada
if (file_exists($data_file)) {
    $lines = file($data_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        // Skip jika bukan format data tamu (misalnya baris login)
        if (strpos($line, 'Username:') !== false) {
            continue;
        }
        
        $parts = explode('|', $line);
        if (count($parts) === 4) {
            $nama = mysqli_real_escape_string($conn, trim($parts[0]));
            $email = mysqli_real_escape_string($conn, trim($parts[1]));
            $pesan = mysqli_real_escape_string($conn, trim($parts[2]));
            $timestamp = mysqli_real_escape_string($conn, trim($parts[3]));
            
            $query = "INSERT INTO entries (nama, email, pesan, timestamp) 
                      VALUES ('$nama', '$email', '$pesan', '$timestamp')";
            
            if (!mysqli_query($conn, $query)) {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
        }
    }
    
    echo "Migrasi data selesai!";
} else {
    echo "File data tidak ditemukan.";
}

mysqli_close($conn);
?>