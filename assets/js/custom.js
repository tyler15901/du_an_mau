// Khởi tạo tooltip cho các icon chức năng - Sử dụng Bootstrap Tooltip để hiển thị mô tả khi hover icon.
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

// Xử lý sticky header khi scroll - Thêm class 'scrolled' hoặc 'shrink' khi cuộn trang để thu nhỏ header và tăng shadow.
window.addEventListener('scroll', function() {
  const header = document.querySelector('.sticky-header');
  header.classList.toggle('scrolled', window.scrollY > 50);
  if (header) {
    if (window.scrollY > 40) {
      header.classList.add('shrink');
    } else {
      header.classList.remove('shrink');
    }
  }
});

// Xử lý toggle search bar - Hiển thị/ẩn thanh tìm kiếm với pointer-events tối ưu
const searchBar = document.getElementById('searchBar');
const searchToggle = document.getElementById('searchToggle');
const closeSearch = document.getElementById('closeSearch');

function showSearchBar() {
  searchBar.classList.remove('d-none');
  searchBar.classList.add('show');
  searchBar.style.pointerEvents = 'auto';
  // Focus vào input khi mở
  const input = searchBar.querySelector('input[type="search"]');
  if (input) input.focus();
}

function hideSearchBar() {
  searchBar.classList.add('d-none');
  searchBar.classList.remove('show');
  searchBar.style.pointerEvents = 'none';
}

searchToggle.addEventListener('click', function(e) {
  e.preventDefault();
  if (searchBar.classList.contains('d-none')) {
    showSearchBar();
  } else {
    hideSearchBar();
  }
});

closeSearch.addEventListener('click', function() {
  hideSearchBar();
});

// Login form AJAX (placeholder) - Xử lý form đăng nhập qua AJAX, hiện alert placeholder khi submit.
document.getElementById('loginForm').addEventListener('submit', function(e) {
  e.preventDefault();
  alert('Đăng nhập thành công!');
});

// Add to cart AJAX - Xử lý thêm sản phẩm vào giỏ hàng qua AJAX, cập nhật badge cart và alert thành công.
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

// Copyright year - Cập nhật năm bản quyền động bằng năm hiện tại.
document.getElementById('copyright-year').innerHTML = new Date().getFullYear();