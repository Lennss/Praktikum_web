<?php
session_start();
require 'koneksi.php';

$products = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kopi Kenangan Senja</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
    rel="stylesheet">

  <script src="https://unpkg.com/feather-icons"></script>

  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <!-- Navbar start -->
  <nav class="navbar">
    <a href="#" class="navbar-logo">kenangan<span>senja</span>.</a>

    <div class="navbar-nav">
      <a href="#home">Home</a>
      <a href="#about">Tentang Kami</a>
      <a href="#products">Produk</a>
      <a href="#contact">Kontak</a>
      <a href="riwayat-pemesanan.php">Riwayat Pemesanan</a>
    </div>

    <div class="navbar-extra">
      <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
          <a href="login/logout.php"><i data-feather="user"></i></a>
      <?php else: ?>
          <a href="login/login.php"><i data-feather="user-x"></i></a>
      <?php endif; ?>

      <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
    </div>
  </nav>
  <!-- Navbar end -->

  <!-- Hero Section start -->
  <section class="hero" id="home">
    <div class="mask-container">
      <main class="content">
        <h1>Mari Nikmati Secangkir <span>Kopi</span></h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, enim.</p>
      </main>
    </div>
  </section>
  <!-- Hero Section end -->

  <!-- About Section start -->
  <section id="about" class="about">
    <h2><span>Tentang</span> Kami</h2>

    <div class="row">
      <div class="about-img">
        <img src="img/tentang-kami.png" alt="Tentang Kami">
      </div>
      <div class="content">
        <h3>Kenapa memilih kopi kami?</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur ducimus voluptatum dolor. Et, voluptatum
          accusantium!</p>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic deserunt iure amet facilis eos a quo cum
          voluptates molestias nihil.</p>
      </div>
    </div>
  </section>
  <!-- About Section end -->

  <!-- Products Section start -->
  <section class="products" id="products">
    <h2><span>Produk</span> Kami</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo unde eum, ab fuga possimus iste.</p>

    <div class="row">
      <?php while ($product = mysqli_fetch_assoc($products)): ?>
      <div class="product-card">
        <div class="product-icons">
          <a href="pembayaran.php?product_id=<?= $product['id'] ?>&name=<?= urlencode($product['name']) ?>&price=<?= urlencode($product['price']) ?>&image=<?= urlencode($product['image']) ?>" class="item-detail-button">
            <i data-feather="shopping-cart"></i>
          </a>
          <!-- Add onclick event to show product details -->
          <a href="#" class="item-detail-button" onclick="showProductDetails('<?= $product['name'] ?>', '<?= $product['price'] ?>', '<?= $product['description'] ?>', 'img/products/<?= $product['image'] ?>')">
            <i data-feather="eye"></i>
          </a>
        </div>
        <div class="product-image">
          <img src="img/products/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
        </div>
        <div class="product-content">
          <h3><?= $product['name'] ?></h3>
          <div class="product-price"><?= $product['price'] ?></div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </section>
  <!-- Products Section end -->

  <!-- Popup -->
  <div id="product-popup" class="product-popup">
    <div class="popup-content">
      <span class="close-popup" onclick="hideProductDetails()">&times;</span>
      <div class="image">
        <img id="popup-image" src="" alt="Product Image" class="popup-image">
      </div>
      <div class="desc">
        <h3 id="popup-name"></h3>
        <div id="popup-price" class="popup-price"></div>
        <p id="popup-description" class="popup-description"></p>
        <a href="#" id="popup-add-to-cart" class="item-detail-button add-to-cart">
          <i data-feather="shopping-cart"></i> Add to Cart
        </a>
      </div>
    </div>
  </div>


  <!-- Contact Section start -->
  <section id="contact" class="contact">
    <h2><span>Kontak</span> Kami</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, provident.</p>

    <div class="row">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.56347862248!2d107.57311709235512!3d-6.903444341687889!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a1f93d3e815b2!2sBandung%2C%20Bandung%20City%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1672408575523!5m2!1sen!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>

      <div class="text">
          <h3>Kenangan Coffee</h3>
          <h3>Jl. Kenangan Senja No. 123, Bandung, Jawa Barat</h3>
          <h3>0812-3456-7890</h3>
          <h3>Kenangan@gmail.com</h3>
      </div>
    </div>
  </section>
  <!-- Contact Section end -->

  <!-- Footer start -->
  <footer>
    <div class="socials">
      <a href="#"><i data-feather="instagram"></i></a>
      <a href="#"><i data-feather="twitter"></i></a>
      <a href="#"><i data-feather="facebook"></i></a>
    </div>

    <div class="links">
      <a href="#home">Home</a>
      <a href="#about">Tentang Kami</a>
      <a href="#menu">Menu</a>
      <a href="#contact">Kontak</a>
    </div>

    <div class="credit">
      <p>Created by <a href="">Kenagan Coffee</a>. | &copy; 2024.</p>
    </div>
  </footer>
  <!-- Footer end -->

  <!-- Feather Icons Script -->
  <script>
      feather.replace();
  </script>

  <!-- JavaScript -->
  <script src="js/script.js"></script>
  <script>
    function showProductDetails(name, price, description, image) {
      document.getElementById("popup-name").innerText = name;
      document.getElementById("popup-price").innerText = price;
      
      document.getElementById("popup-description").innerHTML = description;
      
      document.getElementById("popup-image").src = image;

      const popup = document.getElementById("product-popup");
      popup.style.display = "flex"; 
    }

    function hideProductDetails() {
      const popup = document.getElementById("product-popup");
      popup.style.display = "none";
    }

    window.onclick = function(event) {
      const popup = document.getElementById("product-popup");
      if (event.target === popup) {
        hideProductDetails();
      }
    }

  </script>

</body>

</html>
