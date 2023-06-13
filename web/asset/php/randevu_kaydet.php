<?php
include('giriskontrol.php');
session_start();

// Kullanıcının oturum bilgilerini al
$ad = $_SESSION['ad'];
$soyad = $_SESSION['soyad'];
$email = $_SESSION['email'];
$telefon = $_SESSION['telefon'];

// Diğer kodlar devam eder...

?>

<div class="step step-2">
  <form method="POST" action="randevu_kaydet.php">
    <div class="form-group">
      <label for="name">Ad:</label>
      <input type="text" id="name" name="name" value="<?php echo $ad; ?>" required>
    </div>
    <div class="form-group">
      <label for="surname">Soyad:</label>
      <input type="text" id="surname" name="surname" value="<?php echo $soyad; ?>" required>
    </div>
    <div class="form-group">
      <label for="email">E-posta:</label>
      <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
    </div>
    <div class="form-group">
      <label for="phone">Telefon:</label>
      <input type="tel" id="phone" name="phone" value="<?php echo $telefon; ?>" required>
    </div>
    <div class="step-buttons">
      <button class="btn prev">Geri</button>
      <input type="submit" class="btn next" value="Randevu Al">
    </div>
  </form>
</div>
