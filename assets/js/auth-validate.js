function showFieldError(input, message){
  const err = document.createElement('div');
  err.className = 'text-danger small mt-1';
  err.innerText = message;
  clearFieldError(input);
  input.classList.add('is-invalid');
  input.parentElement.appendChild(err);
}
function clearFieldError(input){
  input.classList.remove('is-invalid');
  const old = input.parentElement.querySelector('.text-danger.small');
  if(old) old.remove();
}

function validateLoginForm(form){
  let ok = true;
  const email = form.querySelector('input[name="email"]');
  const password = form.querySelector('input[name="password"]');
  [email,password].forEach(clearFieldError);
  if(!email.value || !/^\S+@\S+\.\S+$/.test(email.value)){ showFieldError(email, 'Email không hợp lệ'); ok=false; }
  if(!password.value || password.value.length < 6){ showFieldError(password, 'Mật khẩu tối thiểu 6 ký tự'); ok=false; }
  return ok;
}

function validateRegisterForm(form){
  let ok = true;
  const ho = form.querySelector('input[name="ho"]');
  const ten = form.querySelector('input[name="ten"]');
  const dob = form.querySelector('input[name="dob"]');
  const email = form.querySelector('input[name="email"]');
  const password = form.querySelector('input[name="password"]');
  const confirm = form.querySelector('input[name="confirm_password"]');
  ;[ho,ten,dob,email,password,confirm].forEach(clearFieldError);
  if(!ho.value.trim()){ showFieldError(ho,'Vui lòng nhập họ'); ok=false; }
  if(!ten.value.trim()){ showFieldError(ten,'Vui lòng nhập tên'); ok=false; }
  if(!/^\d{4}-\d{2}-\d{2}$/.test(dob.value)){ showFieldError(dob,'Ngày sinh (YYYY-MM-DD)'); ok=false; }
  if(!/^\S+@\S+\.\S+$/.test(email.value)){ showFieldError(email,'Email không hợp lệ'); ok=false; }
  if(password.value.length < 6){ showFieldError(password,'Mật khẩu tối thiểu 6 ký tự'); ok=false; }
  if(confirm.value !== password.value){ showFieldError(confirm,'Xác nhận mật khẩu không khớp'); ok=false; }
  return ok;
}

document.addEventListener('DOMContentLoaded', function(){
  const loginForm = document.querySelector('form[action$="post-login"]');
  if(loginForm){
    loginForm.addEventListener('submit', function(e){ if(!validateLoginForm(loginForm)){ e.preventDefault(); }});
  }
  const registerForm = document.querySelector('form[action$="post-register"]');
  if(registerForm){
    registerForm.addEventListener('submit', function(e){ if(!validateRegisterForm(registerForm)){ e.preventDefault(); }});
  }
});


