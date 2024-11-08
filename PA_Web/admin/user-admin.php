<?php
session_start();
require '../koneksi.php';

// Handle user deletion
if (isset($_GET['delete_user_id'])) {
    $user_id = $_GET['delete_user_id'];
    $query = "DELETE FROM users WHERE id = $user_id";
    mysqli_query($conn, $query);
    header("Location: user-admin.php");
    exit();
}

// Search 
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "SELECT * FROM users WHERE username LIKE '%$search%'";
} else {
    $query = "SELECT * FROM users"; // Show all users if no search term is entered
}

$user_result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Users</title>
    <link rel="stylesheet" href="style/user.css">
</head>
<body>
    <!-- Navbar start -->
    <nav class="navbar">
    <a href="#" class="navbar-logo">kenangan<span>senja</span>.</a>

    <div class="navbar-nav">
      <a href="produk-admin.php">Produk</a>
      <a href="pesanan-admin.php">Pesanan</a>
      <a href="#user-admin">User</a>
    </div>

    <div class="navbar-extra">
      <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
          <a href="../login/logout.php"><i data-feather="user"></i></a>
      <?php else: ?>
          <a href="../login/login.php"><i data-feather="user-x"></i></a>
      <?php endif; ?>

      <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
    </div>
  </nav>

  <!-- Search Form -->
  <form action="user-admin.php" method="get" style="margin-bottom: 1rem;" class="search">
      <input type="text" id="search-input" name="search" placeholder="Search by username" value="<?= htmlspecialchars($search) ?>">
      <button type="submit" id="search-btn">Search</button>
  </form>

  <!-- Navbar end -->
    <div class="container">
        <!-- User Management Section -->
        <h2 id="users">Registered Users</h2>
    
        <!-- User Table -->
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nomor Handpone</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            <?php while ($user = mysqli_fetch_assoc($user_result)): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['nomor_hp']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
                <td>
                    <a href="user-admin.php?delete_user_id=<?= $user['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

    <script src="https://unpkg.com/feather-icons"></script>
    <script>feather.replace()</script>
</body>
</html>
