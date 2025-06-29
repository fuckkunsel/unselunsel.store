<?php
require 'db.php';

$min_price = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
$max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 10000;

$stmt = $pdo->prepare("SELECT * FROM products WHERE price BETWEEN ? AND ?");
$stmt->execute([$min_price, $max_price]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <title>UNNATURAL_SELECTION</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css ">
  <script src="main.js"></script>
  <script src="index.js"></script>
</head>
<body>
<?php include 'header.php'; ?>

<!-- Товары -->
<main class="products">
  <div class="product-grid">
<?php foreach ($products as $product): ?>
  <a href="product.php?id=<?= $product['id'] ?>" class="product-card"
     style="--bg-main: url('<?= htmlspecialchars($product['image_path']) ?: '/uploads/placeholder.png' ?>');
            --bg-hover: url('<?= htmlspecialchars($product['hover_image_path'] ?: $product['image_path']) ?>');">
    <div class="product-image"></div>
    <h3><?= htmlspecialchars($product['name']) ?></h3>
    <p>Цена: <?= number_format($product['price'], 2, ',', ' ') ?> руб.</p>
</a>
<?php endforeach; ?>
  </div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>