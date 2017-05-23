let form = document.getElementById('formCadastroVendedor');
let divSuccess = document.getElementById('salvoCadastroVendedor');
let preloader = document.getElementById('preloader');

form.className = "form_seller_show";
divSuccess.className = "form_seller_hidden";
preloader.className = "form_seller_hidden";

form.addEventListener('submit', (e) => {
  e.preventDefault();
  let data = new FormData(form);
  let action = form.getAttribute('action');
  preloader.className = "form_seller_show";

  let headers= {
    'content-Type': 'application/x-www-form-urlencoded',
    'X-CSRF-TOKEN': window.Laravel.csrfToken
  };
  window.axios.post(action, data, {headers: headers}).then(() => {
    form.className = "form_seller_hidden";
    divSuccess.className = "form_seller_show";
    preloader.className = "form_seller_hidden";
  });
});