<?php
session_start();

// Oturum durumunu kontrol et
if (!isset($_SESSION['email']) || !isset($_SESSION['password'])) {
    // Oturum kapalı ise kullanıcıyı login.php sayfasına yönlendir
    header("Location: ./login.php");
    exit;
}

// Oturum açık ise oturumu sonlandır
session_destroy();

// JavaScript ile bir alert uyarısı göster ve kullanıcıyı login.php sayfasına yönlendir
echo '<script>alert("Oturumunuz sonlandırıldı!"); window.location.href = "./login.php";</script>';
exit;
?>

?>
