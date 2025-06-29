<?php require 'db.php'; ?>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="header.css">
<header class="header">
  <div class="container">
    <div class="logo-container">
      <a href="index.php" class="logo">
        <img src="uploads/unnaturalb.png" alt="Логотип" width="250" height="100">
      </a>
    </div>
    <div class="user-actions">
      <?php if (isset($_SESSION['user'])): ?>
        <a href="#"><i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['user']['first_name']) ?></a>
      <?php else: ?>
        <a href="login_register.php"><i class="fas fa-user"></i></a>
      <?php endif; ?>
      <!-- Кнопка корзины -->
      <button id="cart-toggle">
        <i class="fas fa-shopping-cart"></i>
        <span id="cart-count">0</span>
      </button>
    </div>
  </div>

  <!-- Модальное окно корзины -->
  <div id="cart-modal" class="cart-modal">
    <div class="cart-content">
      <span class="close-cart">&times;</span>
      <h2>Ваша корзина</h2>
      <div id="cart-items"></div>
      <div id="cart-total">Итого: 0 ₽</div>
      <!-- Форма оформления заказа -->
      <form id="checkout-form" style="display: none;">
        <input type="text" id="name" placeholder="Имя" required>
        <input type="text" id="address" placeholder="Адрес доставки" required>
        <input type="email" id="email" placeholder="Email" required>
        <input type="tel" id="phone" placeholder="Телефон" required>
        <button type="submit">Оформить заказ</button>
      </form>
      <button id="checkout-btn">Оформить заказ</button>
    </div>
  </div>
</header>
<script src="main.js"></script>