<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $nomor_hp = trim($_POST['nomor_hp']);

    if (strlen($username) < 3 || strlen($username) > 20) {
        echo "<script>alert('Username harus antara 3 dan 20 karakter.');</script>";
        exit;
    }

    if (!preg_match("/^\+?\d{10,15}$/", $nomor_hp)) {
        echo "<script>alert('Format nomor HP tidak valid.');</script>";
        exit;
    }

    $role = ($username === 'admin') ? 'Admin' : 'User';

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    require "../koneksi.php";  

    $checkQuery = "SELECT * FROM users WHERE username = ?";
    $checkStmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStmt, "s", $username);
    mysqli_stmt_execute($checkStmt);
    $checkResult = mysqli_stmt_get_result($checkStmt);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('Username sudah digunakan. Silakan pilih username lain.');</script>";
        exit;
    }

    $query = "INSERT INTO users (username, password, nomor_hp, role) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $username, $hashed_password, $nomor_hp, $role);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Registrasi berhasil!'); document.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan. Silakan coba lagi.');</script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Kenangan Senja</title>
    <link rel="stylesheet" href="../css/styleLogin.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form method="POST" action="register.php">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required minlength="3" maxlength="20">

            <label for="password">Password</label>
            <div class="password-field">
                <input type="password" id="password" name="password" required minlength="8">
                <span class="toggle-password" role="button" aria-label="Toggle password visibility">👁️</span>
            </div>
            
            <label for="nomor_hp">Nomor HP</label>
            <input type="tel" id="nomor_hp" name="nomor_hp" required pattern="^\+?\d{10,15}$" placeholder="e.g. +6281234567890" 
            title="Please enter a valid phone number, e.g. +6281234567890">

            <button type="submit">Daftar</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login disini</a></p>
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
