function updateQuantity(index, change) {
  const xhr = new XMLHttpRequest();
  const formData = new FormData();
  
  formData.append('index', index);
  formData.append('action', change > 0 ? 'increase' : 'decrease');
  
  xhr.open('POST', 'cart.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send(new URLSearchParams(formData));
  
  // Для демонстрации обновления без перезагрузки
  // В реальном проекте используйте AJAX
}

function removeItem(index) {
  const xhr = new XMLHttpRequest();
  const formData = new FormData();
  
  formData.append('index', index);
  formData.append('action', 'remove');
  
  xhr.open('POST', 'cart.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send(new URLSearchParams(formData));
}