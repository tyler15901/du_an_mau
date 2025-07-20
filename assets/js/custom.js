// Toggle search bar
document.getElementById('searchToggle').addEventListener('click', function() {
  document.getElementById('searchBar').classList.toggle('d-none');
});

document.getElementById('closeSearch').addEventListener('click', function() {
  document.getElementById('searchBar').classList.add('d-none');
});

// Login form AJAX (placeholder)
document.getElementById('loginForm').addEventListener('submit', function(e) {
  e.preventDefault();
  alert('Đăng nhập thành công!');
});

// Add to cart AJAX
document.querySelectorAll('.add-to-cart').forEach(button => {
  button.addEventListener('click', function() {
    const productId = this.dataset.productId;
    fetch('/add-to-cart', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `product_id=${productId}`
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        document.querySelector('.badge-cart').textContent = data.cart_count;
        alert('Thêm vào giỏ hàng thành công!');
      }
    })
    .catch(error => console.error('Lỗi add to cart: ', error));
  });
});

// Copyright year
document.getElementById('copyright-year').innerHTML = new Date().getFullYear();