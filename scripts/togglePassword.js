let pwdContainers = document.querySelectorAll('.pwd-container');

pwdContainers.forEach(container => {
  let passwordInput = container.querySelector('input[type="password"]');
  let togglePassword = container.querySelector('.toggle-pwd');

  togglePassword.addEventListener('click', function () {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      togglePassword.classList.add('show-password');
      togglePassword.classList.remove('hide-password');
    } else {
      passwordInput.type = "password";
      togglePassword.classList.add('hide-password');
      togglePassword.classList.remove('show-password');
    }
  });
});
