document.addEventListener('DOMContentLoaded', function() {
	// Admin sidebar toggle
	var sidebarToggle = document.getElementById('sidebarToggle');
	var sidebar = document.getElementById('sidebar');
	if (sidebarToggle && sidebar) {
		sidebarToggle.addEventListener('click', function() {
			sidebar.classList.toggle('show');
		});
		document.addEventListener('click', function(e) {
			if (window.innerWidth <= 768) {
				if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
					sidebar.classList.remove('show');
				}
			}
		});
	}

	// Admin confirm delete (users, products, categories, reviews)
	window.confirmDelete = function(id, name) {
		var currentPage = document.body.getAttribute('data-current-page') || '';
		var route = '';
		var message = '';
		switch (currentPage) {
			case 'users':
				route = 'users/delete/';
				message = 'Bạn có chắc chắn muốn xóa người dùng "' + (name || '') + '"?';
				break;
			case 'products':
				route = 'products/delete/';
				message = 'Bạn có chắc chắn muốn xóa sản phẩm "' + (name || '') + '"?';
				break;
			case 'categories':
				route = 'categories/delete/';
				message = 'Bạn có chắc chắn muốn xóa danh mục "' + (name || '') + '"?';
				break;
			case 'reviews':
				route = 'reviews/delete/';
				message = 'Bạn có chắc chắn muốn xóa bình luận này?';
				break;
			default:
				return;
		}
		if (confirm(message)) {
			var base = (window.ADMIN_BASE || '').replace(/\/?$/, '/');
			window.location.href = base + route + id;
		}
	};

	// Admin add-product: image preview and form validation
	var imageInput = document.getElementById('image');
	var preview = document.getElementById('imagePreview');
	var noImage = document.getElementById('noImage');
	var previewImg = document.getElementById('previewImg');
	if (imageInput && preview && noImage && previewImg) {
		imageInput.addEventListener('change', function(e) {
			var file = e.target.files[0];
			if (file) {
				var reader = new FileReader();
				reader.onload = function(ev) {
					previewImg.src = ev.target.result;
					preview.style.display = 'block';
					noImage.style.display = 'none';
				};
				reader.readAsDataURL(file);
			} else {
				preview.style.display = 'none';
				noImage.style.display = 'block';
			}
		});
	}

	var formEl = document.querySelector('form');
	if (formEl && document.getElementById('name') && document.getElementById('category_id') && document.getElementById('price') && document.getElementById('stock')) {
		formEl.addEventListener('submit', function(e) {
			var name = document.getElementById('name').value.trim();
			var category = document.getElementById('category_id').value;
			var price = document.getElementById('price').value;
			var stock = document.getElementById('stock').value;
			var imageFileInput = document.getElementById('image');
			var image = imageFileInput ? imageFileInput.files[0] : null;
			if (!name) { e.preventDefault(); alert('Vui lòng nhập tên sản phẩm'); document.getElementById('name').focus(); return false; }
			if (!category) { e.preventDefault(); alert('Vui lòng chọn danh mục'); document.getElementById('category_id').focus(); return false; }
			if (!price || price <= 0) { e.preventDefault(); alert('Vui lòng nhập giá hợp lệ'); document.getElementById('price').focus(); return false; }
			if (stock < 0) { e.preventDefault(); alert('Số lượng tồn kho không được âm'); document.getElementById('stock').focus(); return false; }
			if (imageFileInput && !image) { e.preventDefault(); alert('Vui lòng chọn hình ảnh sản phẩm'); document.getElementById('image').focus(); return false; }
		});
	}

	// Register page password strength and confirmation
	var passwordInput = document.getElementById('password');
	var confirmPasswordInput = document.getElementById('confirm_password');
	var passwordStrengthDiv = document.getElementById('passwordStrength');
	var confirmStrengthDiv = document.getElementById('confirmStrength');
	var registerForm = document.getElementById('registerForm');
	if (passwordInput && passwordStrengthDiv) {
		passwordInput.addEventListener('input', function() {
			var password = this.value;
			var strength = 0;
			var message = '';
			var className = '';
			if (password.length >= 6) strength++;
			if (password.match(/[a-z]/)) strength++;
			if (password.match(/[A-Z]/)) strength++;
			if (password.match(/[0-9]/)) strength++;
			if (password.match(/[^a-zA-Z0-9]/)) strength++;
			switch (strength) {
				case 0:
				case 1: message = 'Rất yếu'; className = 'strength-weak'; break;
				case 2: message = 'Yếu'; className = 'strength-weak'; break;
				case 3: message = 'Trung bình'; className = 'strength-medium'; break;
				case 4: message = 'Mạnh'; className = 'strength-strong'; break;
				case 5: message = 'Rất mạnh'; className = 'strength-strong'; break;
			}
			passwordStrengthDiv.textContent = message;
			passwordStrengthDiv.className = 'password-strength ' + className;
		});
	}
	if (confirmPasswordInput && confirmStrengthDiv) {
		confirmPasswordInput.addEventListener('input', function() {
			var password = passwordInput ? passwordInput.value : '';
			var confirmPassword = this.value;
			if (confirmPassword === '') { confirmStrengthDiv.textContent = ''; confirmStrengthDiv.className = 'password-strength'; }
			else if (password === confirmPassword) { confirmStrengthDiv.textContent = 'Mật khẩu khớp'; confirmStrengthDiv.className = 'password-strength strength-strong'; }
			else { confirmStrengthDiv.textContent = 'Mật khẩu không khớp'; confirmStrengthDiv.className = 'password-strength strength-weak'; }
		});
	}
	if (registerForm) {
		registerForm.addEventListener('submit', function(e) {
			var password = passwordInput ? passwordInput.value : '';
			var confirmPassword = confirmPasswordInput ? confirmPasswordInput.value : '';
			if (password !== confirmPassword) { e.preventDefault(); alert('Mật khẩu xác nhận không khớp!'); return false; }
			if (password.length < 6) { e.preventDefault(); alert('Mật khẩu phải có ít nhất 6 ký tự!'); return false; }
		});
	}

	// Products page: auto submit when category filter changes
	var categoryRadios = document.querySelectorAll('input[name="category"]');
	if (categoryRadios && categoryRadios.length) {
		categoryRadios.forEach(function(radio) {
			radio.addEventListener('change', function() {
				var form = document.createElement('form');
				form.method = 'GET';
				var productsRoute = (window.BASE_URL ? (window.BASE_URL.replace(/\/?$/, '/') + 'products') : window.location.pathname);
				form.action = productsRoute;
				var input = document.createElement('input');
				input.type = 'hidden';
				input.name = 'category';
				input.value = this.value;
				form.appendChild(input);
				var urlParams = new URLSearchParams(window.location.search);
				for (var pair of urlParams.entries()) {
					var key = pair[0]; var value = pair[1];
					if (key !== 'category') {
						var hiddenInput = document.createElement('input');
						hiddenInput.type = 'hidden';
						hiddenInput.name = key;
						hiddenInput.value = value;
						form.appendChild(hiddenInput);
					}
				}
				document.body.appendChild(form);
				form.submit();
			});
		});
	}

	// Product detail quantity controls and rating input styling
	window.changeQuantity = function(delta) {
		var input = document.getElementById('quantity');
		if (!input) return;
		var newValue = parseInt(input.value || '0', 10) + delta;
		var max = parseInt(input.getAttribute('max') || '9999', 10);
		var min = parseInt(input.getAttribute('min') || '1', 10);
		if (newValue >= min && newValue <= max) { input.value = newValue; }
	};
	var ratingRadios = document.querySelectorAll('.rating-input input[type="radio"]');
	if (ratingRadios && ratingRadios.length) {
		ratingRadios.forEach(function(radio) {
			radio.addEventListener('change', function() {
				var rating = parseInt(this.value, 10);
				document.querySelectorAll('.rating-input label i').forEach(function(star, index) {
					star.className = (index < rating) ? 'fas fa-star' : 'far fa-star';
				});
			});
		});
	}
});


