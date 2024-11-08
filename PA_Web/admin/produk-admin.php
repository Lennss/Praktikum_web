<?php
session_start();
require '../koneksi.php';


// Tambah produk
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $target = '../img/products/' . basename($image);

    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $query = "INSERT INTO products (name, price, description, image) VALUES ('$name', '$price', '$description', '$image')";
    mysqli_query($conn, $query);
}

// Hapus produk
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $query = "DELETE FROM products WHERE id = $id";
    mysqli_query($conn, $query);
    header("Location: produk-admin.php");
}

// Edit produk
if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
    $product = mysqli_fetch_assoc($result);
}

// Update produk
if (isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'] ? $_FILES['image']['name'] : $_POST['old_image'];
    $target = '../img/products/' . basename($image);

    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $query = "UPDATE products SET name='$name', price='$price', description='$description', image='$image' WHERE id=$id";
    mysqli_query($conn, $query);
    header("Location: produk-admin.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Manage Products</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
    rel="stylesheet">

  <script src="https://unpkg.com/feather-icons"></script>

  <link rel="stylesheet" href="style/produk.css">
</head>
<body>
    <!-- Navbar start -->
    <nav class="navbar">
    <a href="#" class="navbar-logo">kenangan<span>senja</span>.</a>

    <div class="navbar-nav">
      <a href="#home">Produk</a>
      <a href="pesanan-admin.php">Pesanan</a>
      <a href="user-admin.php">User</a>
    </div>

    <div class="navbar-extra">
      <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
          <a href="../login/logout.php"><i data-feather="user"></i></a>
      <?php else: ?>
          <a href="../login/login.html"><i data-feather="user-x"></i></a>
      <?php endif; ?>

      <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
    </div>
  </nav>
  <!-- Navbar end -->

  <div class="content">
    <div class="tambah-produk">
        <h1>Manage Products</h1>
        <!-- Form untuk tambah produk -->
        <h2>Tambah Produk</h2>
        <form action="produk-admin.php" method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required><br>
            <input type="text" name="price" placeholder="Product Price" required><br>
            <textarea name="description" placeholder="Product Description" required></textarea><br>
            <input type="file" name="image" required><br>
            <button type="submit" name="add_product">Tambah</button>
        </form>
    </div>
    <div class="edit-produk">
        <?php if (isset($product)): ?>
        <style>
            .tambah-produk {
                display: none;
            }
        </style>

        <h2>Ubah Produk</h2>
        <form action="produk-admin.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $product['id'] ?>">
            <input type="text" name="name" value="<?= $product['name'] ?>" required><br>
            <input type="text" name="price" value="<?= $product['price'] ?>" required><br>
            <textarea name="description" required><?= $product['description'] ?></textarea><br>
            <input type="file" name="image"><br>
            <input type="hidden" name="old_image" value="<?= $product['image'] ?>">
            <button type="submit" name="update_product">Ubah</button>
        </form>
        <?php endif; ?>
    </div>
  
    <h2>Produk</h2>
    <table>
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Deskripsi</th>
            <th>Gambar</th>
            <th>Actions</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM products");
        while ($product = mysqli_fetch_assoc($result)):
        ?>
        <tr>
            <td><?= $product['name'] ?></td>
            <td><?= $product['price'] ?></td>
            <td><?= $product['description'] ?></td>
            <td><img src="../img/products/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" width="100"></td>
            <td>
                <a href="produk-admin.php?edit_id=<?= $product['id'] ?>">Edit</a> | 
                <a href="produk-admin.php?delete_id=<?= $product['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
  </div>


  <script>
  feather.replace()
  </script>
</body>
</html>
