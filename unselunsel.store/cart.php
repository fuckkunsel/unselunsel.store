<?php
session_start();
require 'db.php';

// Получаем данные из сессии
$cart = $_SESSION['cart'] ?? [];

// Обработка действий (увеличить/уменьшить/удалить)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $index = $_POST['index'];
        $action = $_POST['action'];

        if ($action === 'increase') {
            $cart[$index]['quantity']++;
        } elseif ($action === 'decrease') {
            if ($cart[$index]['quantity'] > 1) {
                $cart[$index]['quantity']--;
            }
        } elseif ($action === 'remove') {
            unset($cart[$index]);
            $cart = array_values($cart); // Перенумеруем массив
        }

        $_SESSION['cart'] = $cart;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Корзина</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="cart.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="products">
  <div class="container">
    <!-- Основное содержимое страницы -->
    <div class="product-details">
      <!-- Здесь будет ваш текущий товар -->
    </div>

    <!-- Корзина -->
    <aside class="cart-sidebar">
      <h2>Ваша корзина</h2>
      <button class="close-cart">&times;</button>
      
      <?php if (empty($cart)): ?>
        <p>Корзина пуста.</p>
      <?php else: ?>
        <?php $total = 0; foreach ($cart as $index => $item): ?>
          <div class="cart-item">
            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
            <div class="cart-item-info">
              <h3><?= htmlspecialchars($item['name']) ?></h3>
              <p>Цена: <?= number_format($item['price'], 2, ',', ' ') ?> ₽</p>
              <div class="quantity-control">
                <button onclick="updateQuantity(<?= $index ?>, -1)">-</button>
                <span><?= $item['quantity'] ?></span>
                <button onclick="updateQuantity(<?= $index ?>, 1)">+</button>
              </div>
              <button class="remove-item" onclick="removeItem(<?= $index ?>)">Удалить</button>
            </div>
          </div>
          <?php $total += $item['price'] * $item['quantity']; ?>
        <?php endforeach; ?>
        
        <div class="cart-total">
          <p>Итого: <span><?= number_format($total, 2, ',', ' ') ?> ₽</span></p>
          <button class="checkout-btn">Оформить заказ</button>
        </div>
      <?php endif; ?>
    </aside>
  </div>
</main>

<script src="js/main.js"></script>
<script src="js/cart.js"></script>
<?php include 'footer.php'; ?>
</body>
</html>