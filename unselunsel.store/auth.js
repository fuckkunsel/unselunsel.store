// auth.js
document.addEventListener('DOMContentLoaded', () => {
  // Здесь можно добавить валидацию форм
  
  const passwordInput = document.getElementById('password');
  const validationItems = document.querySelectorAll('.password-validation-item');

  passwordInput.addEventListener('input', function() {
    const password = this.value;
    
    // Проверка длины
    validationItems[0].classList.remove('password-validation-error');
    if (password.length < 8) {
      validationItems[0].classList.add('password-validation-error');
    }
    
    // Проверка на наличие цифры
    validationItems[1].classList.remove('password-validation-error');
    if (!/[0-9]/.test(password)) {
      validationItems[1].classList.add('password-validation-error');
    }
    
    // Проверка на наличие заглавных и строчных букв
    validationItems[2].classList.remove('password-validation-error');
    if (!/[A-Z]/.test(password) || !/[a-z]/.test(password)) {
      validationItems[2].classList.add('password-validation-error');
    }
  });
});