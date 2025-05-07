<?php
session_start();
require_once 'db_connect.php';

// Cek login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$guests = [];

// Jika form dikirim (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = htmlspecialchars($_POST['nama']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $pesan = htmlspecialchars($_POST['pesan']);

    if ($nama && $email && $pesan) {
        // Simpan ke database
        $nama = mysqli_real_escape_string($conn, $nama);
        $email = mysqli_real_escape_string($conn, $email);
        $pesan = mysqli_real_escape_string($conn, $pesan);
        
        $query = "INSERT INTO entries (nama, email, pesan) VALUES ('$nama', '$email', '$pesan')";
        
        if (mysqli_query($conn, $query)) {
            // Redirect untuk menghindari refresh form submission
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}

// Baca data dari database
$query = "SELECT * FROM entries ORDER BY timestamp DESC";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $guests[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku Tamu Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #fff0f5; /* light pink */
        font-family: 'Arial', sans-serif;
    }
    .guest-container {
        max-width: 600px;
        margin: 50px auto;
        background-color: #fff; /* putih */
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .form-section {
        background-color: #ffe4f0; /* soft pink */
        padding: 30px;
        border-bottom: 2px solid #f8c8dc;
    }
    .list-section {
        padding: 30px;
    }
    .guest-entry {
        background-color: #fff5f8; /* pastel pinkish */
        border-left: 4px solid #ff85a2; /* soft rose */
        margin-bottom: 15px;
        padding: 15px;
        border-radius: 8px;
    }
    .btn-custom {
        background-color: #ff85a2; /* rose pink */
        border-color: #ff85a2;
        color: white;
        font-weight: bold;
        transition: all 0.3s ease;
        border-radius: 8px;
    }
    .btn-custom:hover {
        background-color: #e56e8d;
        border-color: #e56e8d;
        transform: translateY(-2px);
    }

    input.form-control, textarea.form-control {
        border-radius: 8px;
        border: 1px solid #ffc0cb;
    }

    h2, h3 {
        color: #cc3366;
        font-weight: bold;
    }
    
    .welcome-message {
        background-color: #ffe4f0;
        border-radius: 8px;
        padding: 10px 15px;
        margin-bottom: 20px;
        font-weight: bold;
        color: #cc3366;
    }
</style>

</head>
<body>
    <div class="container-fluid">
        <div class="guest-container">
            <div class="form-section">
                <h2 class="text-center mb-4">Buku Tamu Digital</h2>
                
                <div class="welcome-message">
                    Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                </div>
                
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="pesan" class="form-label">Pesan</label>
                        <textarea class="form-control" id="pesan" name="pesan" rows="3" required></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-custom text-white">Kirim Pesan</button>
                        <a href="logout.php" class="btn btn-outline-danger">Logout</a>
                    </div>
                </form>
            </div>

            <div class="list-section">
                <h3 class="mb-4">Daftar Tamu</h3>
                <?php if (empty($guests)): ?>
                    <div class="alert alert-info text-center">
                        Belum ada catatan tamu
                    </div>
                <?php else: ?>
                    <?php foreach ($guests as $guest): ?>
                        <div class="guest-entry">
                            <h5 class="mb-1"><?php echo $guest['nama']; ?></h5>
                            <p class="text-muted mb-1"><?php echo $guest['email']; ?></p>
                            <p><?php echo $guest['pesan']; ?></p>
                            <small class="text-muted"><?php echo $guest['timestamp']; ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($conn);
?>