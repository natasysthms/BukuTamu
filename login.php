<?php
session_start();

// Redirect jika sudah login
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: guestbook.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Buku Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Work Sans', sans-serif;
        }

        body {
            background-color: #ffeaf4;
            background-image: 
                linear-gradient(#fff 1px, transparent 1px),
                linear-gradient(90deg, #fff 1px, transparent 1px);
            background-size: 20px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        .login-container {
            background-color: #fff0f5;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }

        h2 {
            color: #cc3366;
            margin-bottom: 30px;
            font-weight: bold;
            text-align: center;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ffc0cb;
            background-color: #fffafd;
        }

        .btn-login {
            background-color: #ff85a2;
            border-color: #ff85a2;
            color: white;
            padding: 10px 0;
            font-weight: bold;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #e56e8d;
            border-color: #e56e8d;
            transform: translateY(-2px);
        }

        .alert {
            text-align: center;
            font-weight: bold;
        }

        #error-message {
            display: none;
        }

        #loading-indicator {
            display: none;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Buku Tamu</h2>
        <div id="error-message" class="alert alert-danger"></div>

        <form id="login-form">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-login w-100">Masuk</button>
            <div id="loading-indicator">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </form>
    </div>

    <script>
    $(document).ready(function() {
        $('#login-form').on('submit', function(e) {
            e.preventDefault();
            
            var username = $('#username').val();
            var password = $('#password').val();
            
            $('#error-message').hide();
            $('#loading-indicator').show();
            
            $.ajax({
                url: 'login_process.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    username: username,
                    password: password
                },
                success: function(response) {
                    $('#loading-indicator').hide();
                    
                    if (response.status === 'success') {
                        window.location.href = 'guestbook.php';
                    } else {
                        $('#error-message').text(response.message);
                        $('#error-message').show();
                    }
                },
                error: function() {
                    $('#loading-indicator').hide();
                    $('#error-message').text('Terjadi kesalahan. Silakan coba lagi.');
                    $('#error-message').show();
                }
            });
        });
    });
    </script>
</body>
</html>