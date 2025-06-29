<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
require '../db.php';
$stmt = $pdo->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Админка</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Товары</h2>

<a href="#">Добавить товар</a>

<table border="1" cellpadding="10">
  <tr>
    <th>ID</th><th>Название</th><th>Цена</th><th>Изображение</th><th>Действия</th>
  </tr>
  <?php while ($product = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
  <tr>
    <td><?= $product['id'] ?></td>
    <td><?= htmlspecialchars($product['name']) ?></td>
    <td><?= $product['price'] ?></td>
    <td><img src="<?= $product['image_path'] ?>" width="100"></td>
    <td>
      <a href="#">Редактировать</a>
      <a href="#">Удалить</a>
    </td>
  </tr>
  <?php endwhile; ?>
</table>

</body>
</html>