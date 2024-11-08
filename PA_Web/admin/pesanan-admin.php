<?php
session_start();
include('../koneksi.php'); // Include your database connection

$query = "SELECT id, role FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->bind_result($user_id, $role);
$stmt->close();

$orderQuery = "SELECT riwayat_pesanan.*, users.username FROM riwayat_pesanan JOIN users ON riwayat_pesanan.user_id = users.id";
$result = $conn->query($orderQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders - Admin View</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
        rel="stylesheet">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- My Style -->
    <link rel="stylesheet" href="style/pesanan.css">
</head>
<body>
    <!-- Navbar start -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">kenangan<span>senja</span>.</a>

        <div class="navbar-nav">
        <a href="produk-admin.php">Produk</a>
        <a href="pesanan-admin.php">Pesanan</a>
        <a href="user-admin.php">User</a>
        </div>

        <div class="navbar-extra">
        <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
            <!-- Jika sudah login, tampilkan ikon logout -->
            <a href="../login/logout.php"><i data-feather="user"></i></a>
        <?php else: ?>
            <!-- Jika belum login, tampilkan ikon login -->
            <a href="../login/login.html"><i data-feather="user-x"></i></a>
        <?php endif; ?>

        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
        </div>
    </nav>
  <!-- Navbar end -->

    <h1>Pesanan</h1>
    <div class="content">
        <div class="data">
            <?php
            // Display all orders
            while ($row = $result->fetch_assoc()) {
                echo "<div class='order'>";
                echo "<h3>Pesanan: " . htmlspecialchars($row['product_name']) . "</h3>";
                echo "<p>Harga: Rp " . number_format($row['product_price'], 2) . "</p>";
                echo "<p>Username: " . htmlspecialchars($row['username']) . "</p>";
                echo "<p>Transaksi ID: " . htmlspecialchars($row['transaction_id']) . "</p>";
                echo "<p id='date'>Tanggal Pesan: " . htmlspecialchars($row['order_date']) . "</p>";
                echo "<img src='" . htmlspecialchars($row['qr_code_url']) . "' alt='QR Code'>";
                echo "</div>";
            }

            $result->close();
            ?>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</body>
</html>
