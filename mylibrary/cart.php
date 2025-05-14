<?php
session_start();

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle item removal
if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    if (isset($_SESSION['cart'][$index])) {
        array_splice($_SESSION['cart'], $index, 1);
    }
    header("Location: cart.php");
    exit;
}

// Sample cart structure for demonstration (you can integrate with actual add-to-cart logic)
if (isset($_GET['demo'])) {
    $_SESSION['cart'][] = ["name" => "Sample Book", "price" => 9.99];
    header("Location: cart.php");
    exit;
}

$cart = $_SESSION['cart'];
$totalBooks = count($cart);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Shopping Cart - Library Management</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('background.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
    }
    nav {
      background: rgba(0, 0, 0, 0.8);
      padding: 15px;
      text-align: center;
      width: 100%;
      position: fixed;
      top: 0;
      left: 0;
    }
    nav ul {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      justify-content: center;
    }
    nav ul li {
      margin: 0 15px;
    }
    nav ul li a {
      color: white;
      text-decoration: none;
      font-size: 18px;
      font-weight: bold;
      padding: 10px 15px;
      background: #27ae60;
      border-radius: 5px;
      transition: background 0.3s;
    }
    nav ul li a:hover {
      background: #219150;
    }
    .nav-link.active {
      background: #f39c12;
      color: black;
    }
    .cart-count {
      background: red;
      color: white;
      font-size: 14px;
      padding: 3px 7px;
      border-radius: 50%;
      position: absolute;
      top: 10px;
      right: 10px;
    }
    .container {
      max-width: 900px;
      margin: 100px auto;
      padding: 20px;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }
    .cart-item {
      display: flex;
      justify-content: space-between;
      padding: 10px;
      border-bottom: 1px solid #ccc;
    }
    .cart-item button {
      background: red;
      color: white;
      border: none;
      padding: 5px;
      cursor: pointer;
      border-radius: 5px;
    }
    .cart-item button:hover {
      background: darkred;
    }
    .cart-total {
      font-size: 18px;
      font-weight: bold;
      margin-top: 20px;
    }
  </style>
</head>
<body>
<nav>
  <ul>
    <li><a href="home.html" class="nav-link">Home</a></li>
    <li><a href="products.html" class="nav-link">Books</a></li>
    <li><a href="cart.php" class="nav-link active">Cart <span class="cart-count"><?= $totalBooks ?></span></a></li>
    <li><a href="contact.html" class="nav-link">Contact</a></li>
  </ul>
</nav>

<div class="container">
  <h1>Your Cart</h1>

  <?php if (empty($cart)) : ?>
    <p>Your cart is empty.</p>
  <?php else : ?>
    <?php foreach ($cart as $index => $item) : ?>
      <div class="cart-item">
        <span><?= htmlspecialchars($item['name']) ?> - $<?= number_format($item['price'], 2) ?></span>
        <a href="?remove=<?= $index ?>"><button>Remove</button></a>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <p class="cart-total">Total Books: <?= $totalBooks ?></p>
</div>

</body>
</html>
