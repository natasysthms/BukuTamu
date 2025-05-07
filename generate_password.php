<?php
$password = 'password_baru'; // Ganti dengan password yang diinginkan
$hashed_password = password_hash($password, PASSWORD_BCRYPT);
echo "Password Hash: " . $hashed_password;
?>