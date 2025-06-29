document.addEventListener('DOMContentLoaded', () => {
  const sizeButtons = document.querySelectorAll('.size-option');
  const modal = document.getElementById('modal');
  const modalImage = document.getElementById('modal-image');
  const closeBtn = document.querySelector('.close');

  sizeButtons.forEach(button => {
    button.addEventListener('click', function() {
      // Убираем класс active со всех кнопок
      sizeButtons.forEach(btn => btn.classList.remove('active'));
      
      // Добавляем класс active к текущей кнопке
      this.classList.add('active');
    });
  document.querySelectorAll('.gallery-thumbnails img').forEach(img => {
    img.addEventListener('click', () => {
      modal.style.display = 'flex';
      modalImage.src = img.src;
    });
  });

  // Закрытие модального окна
  closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';
  });

  // Закрытие модального окна при клике вне его
  window.addEventListener('click', (event) => {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  });
  });
});