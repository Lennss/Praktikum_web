<?php
session_start();
include('koneksi.php');


if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo "<script>document.location.href = 'index.php';</script>";
    exit;
}

$username = $_SESSION['username'];

$query = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

$orderQuery = "SELECT * FROM riwayat_pesanan WHERE user_id = ?";
$stmt = $conn->prepare($orderQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
        rel="stylesheet">

    <script src="https://unpkg.com/feather-icons"></script>

    <link rel="stylesheet" href="css/riwayat-pesanan.css">
</head>
<body>
      <!-- Navbar start -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">kenangan<span>senja</span>.</a>

        <div class="navbar-nav">
        <a href="index.php">Home</a>
        <a href="index.php">Tentang Kami</a>
        <a href="index.php">Produk</a>
        <a href="index.php">Kontak</a>
        <a href="riwayat-pemesanan.php">Riwayat Pemesanan</a>
        </div>

        <div class="navbar-extra">
        <a href="#" id="shopping-cart-button"><i data-feather="shopping-cart"></i></a>

        <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
            <a href="login/logout.php"><i data-feather="user"></i></a>
        <?php else: ?>
            <a href="login/login.php"><i data-feather="user-x"></i></a>
        <?php endif; ?>

        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
        </div>

    </nav>
    <!-- Navbar end -->

    <h1>Order History</h1>
    <div class="content">
        <div class="data">
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<div class='order'>";
            echo "<h3>Pesanan: " . htmlspecialchars($row['product_name']) . "</h3>";
            echo "<p>Harga: Rp " . number_format($row['product_price'], 2) . "</p>";
            echo "<p>Transaksi ID: " . htmlspecialchars($row['transaction_id']) . "</p>";
            echo "<img src='" . htmlspecialchars($row['qr_code_url']) . "' alt='QR Code'>";
            echo "</div>";
        }

        $stmt->close();
        ?>
        </div>

    </div>

</body>
</html>
