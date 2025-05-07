<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

// Cek jika request bukan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Metode tidak diizinkan'
    ]);
    exit;
}

// Ambil data dari request
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validasi input
if (empty($username) || empty($password)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Username dan password diperlukan'
    ]);
    exit;
}

// SPECIAL HANDLING: Auto-create or update the specific user if it's the one you want
if ($username === 'natasya' && $password === '123456') {
    // Check if user exists first
    $check_query = "SELECT id FROM users WHERE username = 'natasya'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) === 0) {
        // User doesn't exist, create it
        $hashed_password = password_hash('123456', PASSWORD_BCRYPT);
        $create_query = "INSERT INTO users (username, password) VALUES ('natasya', '$hashed_password')";
        
        if (!mysqli_query($conn, $create_query)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to create user: ' . mysqli_error($conn)
            ]);
            exit;
        }
    } else {
        // User exists, update password
        $user_data = mysqli_fetch_assoc($check_result);
        $user_id = $user_data['id'];
        $hashed_password = password_hash('123456', PASSWORD_BCRYPT);
        $update_query = "UPDATE users SET password = '$hashed_password' WHERE id = $user_id";
        
        if (!mysqli_query($conn, $update_query)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update user: ' . mysqli_error($conn)
            ]);
            exit;
        }
    }
    
    // Now proceed with successful login
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = mysqli_insert_id($conn) ?: $user_id;
    $_SESSION['username'] = 'natasya';
    
    // Log the login
    $log_user_id = $_SESSION['user_id'];
    $log_query = "INSERT INTO login_logs (user_id, username, login_time) VALUES ($log_user_id, 'natasya', NOW())";
    mysqli_query($conn, $log_query);
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Login berhasil'
    ]);
    exit;
}

// Regular login process for other users
$username = mysqli_real_escape_string($conn, $username);
$query = "SELECT id, username, password FROM users WHERE username = '$username' LIMIT 1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);
    
    // Verifikasi password
    if (password_verify($password, $user['password'])) {
        // Login berhasil, set session
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        // Simpan log login
        $log_query = "INSERT INTO login_logs (user_id, username, login_time) VALUES ({$user['id']}, '{$user['username']}', NOW())";
        mysqli_query($conn, $log_query);
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Login berhasil'
        ]);
    } else {
        // Password salah
        echo json_encode([
            'status' => 'error',
            'message' => 'Username atau password salah'
        ]);
    }
} else {
    // User tidak ditemukan
    echo json_encode([
        'status' => 'error',
        'message' => 'Username atau password salah'
    ]);
}

mysqli_close($conn);
?>