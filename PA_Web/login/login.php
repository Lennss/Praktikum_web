<?php
session_start();
require "../koneksi.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Admin Login Cek
    if ($username === 'admin' && $password === 'admin') { 
        $_SESSION['login'] = true;
        $_SESSION['username'] = 'admin';
        $_SESSION['role'] = 'Admin';
        
        echo "<script>
                alert('Login berhasil! Selamat datang, Admin.');
                document.location.href = '../admin/produk-admin.php';
              </script>";
        exit;
    } else {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['login'] = true;
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = 'User';
                $_SESSION['user_id'] = $user['id'];

                echo "<script>
                        alert('Login berhasil!');
                        document.location.href = '../index.php';
                      </script>";
                exit;
            }
        }
        echo "<script>
                alert('Username atau password salah!');
                document.location.href = 'login.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kenangan Senja</title>
    <link rel="stylesheet" href="../css/styleLogin.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form id="loginForm" method="POST" action="">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
            
            <label for="password">Password</label>
            <div class="password-field">
                <input type="password" name="password" id="password" required>
                <span class="toggle-password" role="button" aria-label="Toggle password visibility">👁️</span>
            </div>
            
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>

    <script>
        document.querySelector('.toggle-password').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    </script>
</body>
</html>
