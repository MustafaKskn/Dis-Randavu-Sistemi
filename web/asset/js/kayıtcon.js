document.querySelector('.register').addEventListener('submit', function(e) {
  e.preventDefault();

  var name = document.getElementById('name').value;
  var surname = document.getElementById('surname').value;
  var telefon = document.getElementById('telefon').value;
  var cinsiyet = document.getElementById('cinsiyet').value;
  var email = document.getElementById('email_txt').value;
  var email2 = document.getElementById('email2_text').value;
  var password = document.getElementById('password_txt').value;
  var password2 = document.getElementById('password2_txt').value;

  var errorMessages = document.querySelectorAll('.error-message');
  errorMessages.forEach(function(element) {
      element.innerHTML = '';
  });

  if (name === '') {
      document.getElementById('name').insertAdjacentHTML('afterend', '<div class="error-message">Ad alanı boş bırakılamaz</div>');
  }
  if (surname === '') {
      document.getElementById('surname').insertAdjacentHTML('afterend', '<div class="error-message">Soyad alanı boş bırakılamaz</div>');
  }
  if (telefon === '') {
      document.getElementById('telefon').insertAdjacentHTML('afterend', '<div class="error-message">Telefon numarası alanı boş bırakılamaz</div>');
  }
  if (cinsiyet === '') {
      document.getElementById('cinsiyet').insertAdjacentHTML('afterend', '<div class="error-message">Cinsiyet seçimi yapılmalıdır</div>');
  }
  if (email === '') {
      document.getElementById('email_txt').insertAdjacentHTML('afterend', '<div class="error-message">Email adresi alanı boş bırakılamaz</div>');
  } else if (!validateEmail(email)) {
      document.getElementById('email_txt').insertAdjacentHTML('afterend', '<div class="error-message">Geçerli bir email adresi giriniz</div>');
  }
  if (email2 === '') {
      document.getElementById('email2_text').insertAdjacentHTML('afterend', '<div class="error-message">Email adresi tekrar alanı boş bırakılamaz</div>');
  } else if (!validateEmail(email2)) {
      document.getElementById('email2_text').insertAdjacentHTML('afterend', '<div class="error-message">Geçerli bir email adresi giriniz</div>');
  }
  if (password === '') {
      document.getElementById('password_txt').insertAdjacentHTML('afterend', '<div class="error-message">Şifre alanı boş bırakılamaz</div>');
  }
  if (password2 === '') {
      document.getElementById('password2_txt').insertAdjacentHTML('afterend', '<div class="error-message">Şifre tekrar alanı boş bırakılamaz</div>');
  }

  if (email !== email2) {
      document.getElementById('email2_text').insertAdjacentHTML('afterend', '<div class="error-message">Email adresleri uyuşmuyor</div>');
  }
  if (password !== password2) {
      document.getElementById('password2_txt').insertAdjacentHTML('afterend', '<div class="error-message">Şifreler uyuşmuyor</div>');
  }

  var errorCount = document.querySelectorAll('.error-message').length;
  if (errorCount === 0) {
      var formData = new FormData();
      formData.append('name', name);
      formData.append('surname', surname);
      formData.append('telefon', telefon);
      formData.append('cinsiyet', cinsiyet);
      formData.append('email', email);
      formData.append('password', password);

      var xhr = new XMLHttpRequest();
      xhr.open('POST', './asset/php/kaydet.php', true);
      xhr.onload = function() {
          if (xhr.status === 200) {
              window.location.href = './login.html';
          } else {
              console.log('Form gönderilirken bir hata oluştu. Hata kodu: ' + xhr.status);
          }
      };
      xhr.send(formData);
  }
});

function validateEmail(email) {
  var re = /\S+@\S+\.\S+/;
  return re.test(email);
}

  