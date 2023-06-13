// Giriş formunun submit olayını dinle
document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Formun varsayılan gönderme işlemini durdur

    // Formdaki giriş bilgilerini al
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    // AJAX ile sunucuya giriş isteği gönder
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./asset/php/giriskontrol.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                // Giriş başarılı, oturum açıldı
                alert("Giriş başarılı. Hoş geldiniz!");
            } else {
                // Giriş başarısız, oturum açılmadı
                alert("Geçersiz e-posta veya şifre.");
            }
        }
    };
    xhr.send("email=" + email + "&password=" + password);
});
