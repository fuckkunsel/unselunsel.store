document.addEventListener('DOMContentLoaded', () => {
  // Переключатель темы
  const toggleButton = document.getElementById('theme-toggle');
  if (toggleButton) {
    toggleButton.addEventListener('click', () => {
      const body = document.body;
      body.classList.toggle('dark-mode');
    });
  }
});

// Глобальные функции для работы с корзиной
window.addToCart = function(product) {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const existingItem = cart.find(item => item.id === product.id && item.size === product.size);
  
  if (existingItem) {
    existingItem.quantity++;
  } else {
    cart.push({...product, quantity: 1});
  }

  localStorage.setItem('cart', JSON.stringify(cart));
  updateCart();
};

window.updateQuantity = function(index, change) {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  if (cart[index]) {
    cart[index].quantity = Math.max(1, cart[index].quantity + change);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCart();
  }
};

window.removeItem = function(index) {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  cart.splice(index, 1);
  localStorage.setItem('cart', JSON.stringify(cart));
  updateCart();
};

document.addEventListener('DOMContentLoaded', () => {
  const cartToggle = document.getElementById('cart-toggle');
  const cartModal = document.getElementById('cart-modal');
  const closeCart = document.querySelector('.close-cart');
  const cartItemsContainer = document.getElementById('cart-items');
  const cartCount = document.getElementById('cart-count');
  const cartTotal = document.getElementById('cart-total');
  const checkoutBtn = document.getElementById('checkout-btn');
  const checkoutForm = document.getElementById('checkout-form');

  let cart = JSON.parse(localStorage.getItem('cart')) || [];

  // Открытие/закрытие корзины
  cartToggle?.addEventListener('click', () => {
    cartModal.style.display = 'block';
    updateCart();
  });

  closeCart?.addEventListener('click', () => {
    cartModal.style.display = 'none';
  });

  window.addEventListener('click', (e) => {
    if (e.target === cartModal) {
      cartModal.style.display = 'none';
    }
  });

  // Функция обновления корзины
  function updateCart() {
    cartItemsContainer.innerHTML = '';
    let total = 0;

    cart.forEach((item, index) => {
      const itemDiv = document.createElement('div');
      itemDiv.className = 'cart-item';
      itemDiv.innerHTML = `
        <img src="${item.image}" alt="${item.name}">
        <div class="cart-item-info">
          <div class="cart-item-name">${item.name}</div>
          <div class="cart-item-price">${item.price} × <span>${item.quantity}</span> = ${(item.price * item.quantity).toFixed(2)} ₽</div>
        </div>
        <div class="quantity-control">
          <button onclick="updateQuantity(${index}, -1)">-</button>
          <button onclick="updateQuantity(${index}, 1)">+</button>
          <button onclick="removeItem(${index})" class="remove-item">Удалить</button>
        </div>
      `;
      cartItemsContainer.appendChild(itemDiv);
      total += item.price * item.quantity;
    });

    cartCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartTotal.textContent = 'Итого: ' + total.toFixed(2) + ' ₽';

    // Показываем форму оформления заказа, если есть товары
    checkoutForm.style.display = cart.length > 0 ? 'block' : 'none';
  }

  // Добавление товара в корзину
  window.addToCart = function(productData) {
    const existingItem = cart.find(item => item.id === productData.id && item.size === productData.size);

    if (existingItem) {
      existingItem.quantity++;
    } else {
      cart.push({...productData, quantity: 1});
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCart();
  };

  // Обновление количества
  window.updateQuantity = function(index, change) {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart[index]) {
      cart[index].quantity = Math.max(1, cart[index].quantity + change);
      localStorage.setItem('cart', JSON.stringify(cart));
      updateCart();
    }
  };

  // Удаление товара
  window.removeItem = function(index) {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCart();
  };

  // Открытие формы оформления заказа
  checkoutBtn?.addEventListener('click', () => {
    checkoutForm.style.display = 'block';
    checkoutBtn.style.display = 'none';
  });

  // Валидация формы и оформление заказа
  checkoutForm?.addEventListener('submit', (e) => {
    e.preventDefault();

    const name = document.getElementById('name').value.trim();
    const address = document.getElementById('address').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();

    if (!name || !address || !email || !phone) {
      alert('Заполните все поля');
      return;
    }

    // Здесь можно отправить заказ на сервер
    alert('Заказ оформлен!');
    cart = [];
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCart();
    checkoutForm.style.display = 'none';
    checkoutBtn.style.display = 'block';
  });

  // Пример добавления товара (для страницы продукта)
  document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', () => {
      const product = {
        id: button.dataset.productId,
        name: button.dataset.productName,
        price: parseFloat(button.dataset.productPrice),
        image: button.dataset.productImage,
        size: button.dataset.productSize || 'M'
      };
      addToCart(product);
    });
  });

  // Инициализация корзины
  updateCart();
});
