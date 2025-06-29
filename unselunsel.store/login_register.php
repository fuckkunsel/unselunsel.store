<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'login') {
        // Обработка входа
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header('Location: index.php');
            exit;
        } else {
            $loginError = "Неправильный Email или пароль";
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'register') {
        // Обработка регистрации
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Проверка пароля
        $errors = [];
        if (strlen($password) < 8) {
            $errors[] = "Пароль должен быть минимум 8 символов";
        }
        if (!preg_match('/\d/', $password)) {
            $errors[] = "Пароль должен содержать цифру";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Пароль должен содержать заглавную букву";
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = "Пароль должен содержать строчную букву";
        }

        if (empty($errors)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$first_name, $last_name, $email, $hashed_password])) {
                $registrationSuccess = "Регистрация успешна! Теперь вы можете войти.";
            } else {
                $registrationError = "Ошибка регистрации";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Вход / Регистрация</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="auth.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css ">
  <script src="js/main.js"></script>
  <script src="js/auth.js"></script>
</head>
<body>
</head>
<body>
  <?php include 'header.php'; ?>
<div class="auth-container">
  <!-- Левая часть - Вход -->
  <div class="login-form">
    <h2>SIGN IN TO YOUR EXISTING ACCOUNT</h2>
    <?php if (isset($loginError)): ?>
      <div class="error-message"><?php echo $loginError; ?></div>
    <?php endif; ?>
    <form method="post">
      <input type="hidden" name="action" value="login">
      <div class="form-group">
        <label class="form-label">EMAIL</label>
        <input type="email" name="email" placeholder="Email" required>
      </div>
      <div class="form-group">
        <label class="form-label">PASSWORD</label>
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <a href="#" class="forgot-password">FORGOT YOUR PASSWORD?</a>
      <button type="submit" class="btn">SIGN IN</button>
    </form>
    <a href="index.php" class="return-to-store">< RETURN TO STORE</a>
  </div>

  <!-- Вертикальная линия разделитель -->
  <div class="separator"></div>

  <!-- Правая часть - Регистрация -->
  <div class="register-form">
    <h2>CREATE ACCOUNT</h2>
    <div class="info-box">
      <i class="fas fa-bell"></i>
      BY CREATING AN ACCOUNT, YOU'LL BE ABLE TO MOVE THROUGH THE CHECKOUT PROCESS FASTER, STORE MULTIPLE SHIPPING ADDRESSES, VIEW AND TRACK YOUR ORDERS AND MORE.
    </div>
    
    <?php if (isset($registrationSuccess)): ?>
      <div class="success-message"><?php echo $registrationSuccess; ?></div>
    <?php elseif (isset($registrationError)): ?>
      <div class="error-message"><?php echo $registrationError; ?></div>
    <?php endif; ?>
    
    <form method="post">
      <input type="hidden" name="action" value="register">
      <div class="form-group">
        <label class="form-label">FIRST NAME</label>
        <input type="text" name="first_name" placeholder="First Name" required>
      </div>
      <div class="form-group">
        <label class="form-label">LAST NAME</label>
        <input type="text" name="last_name" placeholder="Last Name" required>
      </div>
      <div class="form-group">
        <label class="form-label">EMAIL</label>
        <input type="email" name="email" placeholder="Email" required>
      </div>
      <div class="form-group password-validation">
        <label class="form-label">PASSWORD</label>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <div class="password-validation-items">
          <div class="password-validation-item <?php echo (isset($errors) && in_array("Пароль должен быть минимум 8 символов", $errors)) ? 'password-validation-error' : ''; ?>">
            <i class="fas fa-times"></i> PASSWORD MUST BE AT LEAST 8 CHARACTERS
          </div>
          <div class="password-validation-item <?php echo (isset($errors) && in_array("Пароль должен содержать цифру", $errors)) ? 'password-validation-error' : ''; ?>">
            <i class="fas fa-times"></i> PASSWORD MUST CONTAIN A NUMBER
          </div>
          <div class="password-validation-item <?php echo (isset($errors) && (in_array("Пароль должен содержать заглавную букву", $errors) || in_array("Пароль должен содержать строчную букву", $errors))) ? 'password-validation-error' : ''; ?>">
            <i class="fas fa-times"></i> PASSWORD MUST CONTAIN BOTH UPPER & LOWERCASE CHARACTERS
          </div>
        </div>
      </div>
      <button type="submit" class="btn">CREATE</button>
    </form>
  </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>