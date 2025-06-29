<?php
require 'db.php';
$product_id = $_GET['id'] ?? null;

if (!$product_id) {
    die("Товар не найден.");
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Товар не найден.");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($product['name']) ?> | UNNATURAL_SELECTION</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="product.css">
</head>
<body>
<?php include 'header.php'; ?>

<!-- Хлебные крошки -->
<div class="breadcrumb-container">
  <div class="prod-container">
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Главная</a></li>
        <li class="breadcrumb-item active"><?= htmlspecialchars($product['name']) ?></li>
      </ol>
    </nav>
  </div>
</div>

<section class="product-details">
  <div class="container">
    <!-- Галерея изображений -->
    <div class="product-gallery">
      <div class="gallery-thumbnails">
        <?php if (!empty($product['image_path'])): ?>
          <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="Миниатюра 1">
        <?php endif; ?>
        <?php if (!empty($product['hover_image_path'])): ?>
          <img src="<?= htmlspecialchars($product['hover_image_path']) ?>" alt="Миниатюра 2">
        <?php endif; ?>
      </div>
      <div class="gallery-main">
        <img src="<?= htmlspecialchars($product['full_image_path'] ?: $product['image_path']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
      </div>
    </div>

    <!-- Информация о товаре -->
    <div class="product-info">
      <h1><?= htmlspecialchars($product['name']) ?></h1>
      <div class="price">
        <p>₽<?= number_format($product['price'], 2, ',', ' ') ?></p>
      </div>
      <!-- Размер -->
      <div class="size-selector">
        <span class="size-title">РАЗМЕР</span>
        <div class="size-options">
          <button class="size-option">S</button>
          <button class="size-option active">M</button>
          <button class="size-option">L</button>
          <button class="size-option">XL</button>
          <button class="size-option">2XL</button>
        </div>
      </div>
      <!-- Количество -->
      <div class="quantity-control">
        <span class="quantity-title">КОЛИЧЕСТВО</span>
        <button class="quantity-btn" id="decrease">-</button>
        <input type="number" class="quantity-input" id="quantity" value="1" min="1">
        <button class="quantity-btn" id="increase">+</button>
      </div>
      <!-- Кнопка "Добавить в корзину" -->
      <button id="add-to-cart" class="add-to-cart"
        data-product-id="<?= $product['id'] ?>"
        data-product-name="<?= htmlspecialchars($product['name']) ?>"
        data-product-price="<?= $product['price'] ?>"
        data-product-image="<?= htmlspecialchars($product['image_path']) ?>"
        data-product-size="M">
  Добавить в корзину
</button>
      <!-- Дата доставки -->
      <div class="shipping-info">
        <p><strong>Доставка:</strong> <?= htmlspecialchars($product['shipping_date'] ?? 'Не указана') ?></p>
      </div>
      <!-- Описание -->
      <div class="product-description">
        <p><?= htmlspecialchars($product['description'] ?? 'Нет описания') ?></p>
      </div>
    </div>
  </div>

  <!-- Модальное окно -->
<div id="modal" class="modal">
  <span class="close">&times;</span>
  <img id="modal-image" src="" alt="Увеличенное изображение">
</div>
</section>
<script>
  function updateQuantity(change) {
    const quantityInput = document.getElementById('quantity');
    let currentQuantity = parseInt(quantityInput.value);
    quantityInput.value = Math.max(currentQuantity + change, 1);
  }
</script>
<script src="product.js"></script>
<script src="main.js"></script>
<?php include 'footer.php'; ?>
</body>
</html>