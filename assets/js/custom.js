// Tooltip Bootstrap
document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));

// Sticky header on scroll
window.addEventListener('scroll', function() {
    const header = document.querySelector('.sticky-header');
    if (header) header.classList.toggle('sticky', window.scrollY > 0);
});

// Toggle search bar
const searchToggle = document.querySelector('.search-toggle');
if (searchToggle) {
    searchToggle.addEventListener('click', function() {
        document.querySelector('.search-bar').classList.toggle('d-none');
    });
};

// AJAX add to cart (gửi POST đến controller)
function addToCart(productId) {
    fetch(BASE_URL + 'index.php?act=add-to-cart', { //BASE_URL từ env.php, echo ở header.php
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({product_id: productId})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Thêm vào giỏ thành công!'); // Sau này update badge cart
        } else {
            alert('Lỗi: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

// Login form
const loginForm = document.querySelector('#login-form');
if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Login xử lý ở controller');
    });
}

// Copyright year động
document.querySelector('.copyright-year').textContent = new Date().getFullYear();