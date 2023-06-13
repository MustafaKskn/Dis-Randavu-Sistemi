<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
  <link rel="icon" href="../images/ikon.webp">

  <title>Profil</title>
</head>

<body>
  <nav>
  <div class="logo-name">
        <div class="logo-imge">
          <img src="../images/ikon.webp" alt="logo">
        </div>

        <span class="logo_name">Kullanıcı Paneli</span>
      </div>

      <div class="menu-items">
        <ul class="nav-links">
          <li>
            <a href="dashboard.php">
              <i class="uil uil-estate"></i>
              <span class="link-name">Anasayfa</span>
            </a>
          </li>
          <li>
            <a href="profil.php">
              <i class="uil uil-user"></i>
              <span class="link-name">Profil</span>
            </a>
          </li>
          <li>
            <a href="userranal.php">
            <i class="fa-regular fa-calendar-days"></i>
              <span class="link-name">Randevu Al</span>
            </a>
          </li>
          <li>
            <a href="randevularım.php">
            <i class="fa-solid fa-calendar-check"></i>
              <span class="link-name">Randevularım</span>
            </a>
          </li>

          <li><a href="İşlemler.php">
              <i class="uil uil-chart"></i>
              <span class="link-name">İşlemler</span>
            </a></li>
          <li><a href="İletişim.php">
              <i class="fa-solid fa-inbox"></i>
              <span class="link-name">İletişim</span>
            </a></li>
          <li>
            <a href="Yardım.php">
              <i class="uil uil-comment-question"></i>
              <span class="link-name">Yardım</span>
            </a>
          </li>
          
        </ul>
        <ul class="logout-mod">
          <li><a href="logout.php">
              <i class="uil uil-signout"></i>
              <span class="link-name">Logout</span>
            </a></li>

          <li class="mode">
            <a href="#">
              <i class="uil uil-moon"></i>
              <span class="link-name">Dark Mode</span>
            </a>

            <div class="mode-toggle">
              <span class="switch"></span>
            </div>

          </li>
        </ul>

      </div>

  </nav>
  <div class="col-15" style="height: 50.2vw; background-color: var(--primary-color); color: var(--text-color); padding-top: 20px;">
    <?php
    session_start();
    $conn = mysqli_connect("localhost", "root", "", "dental");
    if (!$conn) {
      die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
    }

    if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['telefon']) && isset($_POST['cinsiyet']) && isset($_POST['email_txt'])) {
      $name = $_POST['name'];
      $surname = $_POST['surname'];
      $telefon = $_POST['telefon'];
      $cinsiyet = $_POST['cinsiyet'];
      $email = $_POST['email_txt'];

      // Update user's profile information in the database
      $sql = "UPDATE uyebilgileri_tablosu SET ad = '$name', surname = '$surname', telefon = '$telefon', cinsiyet = '$cinsiyet' WHERE email = '$email'";
      $result = $conn->query($sql);

      if ($result) {
        echo "Profil bilgileri güncellendi.";
      } else {
        echo "Profil bilgileri güncellenirken bir hata oluştu.";
      }
    } // Profili silme işlemini kontrol et
    if (isset($_POST['delete_profile'])) {
      $email = $_SESSION["email"];
    
      // Profili silmek için gerekli kodu buraya ekleyin (veritabanından ilgili kaydı silmek vb.)
      // Silme işlemi başarılı olduğunda kullanıcıyı uyarmak için aşağıdaki kodu kullanabilirsiniz:
      $sql_delete = "DELETE FROM uyebilgileri_tablosu WHERE email = '$email'";
      if ($conn->query($sql_delete) === TRUE) {
        echo '<script>alert("Profil başarıyla silindi."); window.location.href = "login.php";</script>';
        // Profil başarıyla silindiğini belirten parametreyi URL'ye ekleyin ve sayfayı yeniden yükleyin
        
        exit();
      } else {
        echo "Profil silme işlemi başarısız oldu.";
      }
    }
    

    $email = $_SESSION["email"];

    // Query the user in the database
    $sql = "SELECT id, ad, surname, telefon, cinsiyet, email FROM uyebilgileri_tablosu WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();

      $ad = $row["ad"];
      $soyad = $row["surname"];
      $telefon = $row["telefon"];
      $cinsiyet = $row["cinsiyet"];
      $email = $row["email"];
    ?>

      <div class="col-15" style="height: 50.2vw; background-color: var(--primary-color); color: var(--text-color); padding-top: 20px;">
        <div class="container">
          <div class="row">
            <div class="col-md-6 offset-md-3">
              <h1>Profil Bilgileri</h1>
              <form method="post">
                <div class="row">
                  <div class="col">
                    <div class="form-outline mb-2" style="width: 200px">
                      <label class="form-label" for="name">Ad</label>
                      <input type="text" id="name" name="name" class="form-control" value="<?php echo $ad; ?>" readonly>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-outline mb-2" style="width: 200px">
                      <label class="form-label" for="surname">Soyad</label>
                      <input type="text" id="surname" name="surname" class="form-control" value="<?php echo $soyad; ?>" readonly>
                    </div>
                  </div>
                </div>
                <div class="form-outline mb-2">
                  <label class="form-label" for="telefon">Telefon Numarası</label>
                  <input type="tel" id="telefon" name="telefon" class="form-control" value="<?php echo $telefon; ?>">
                </div>
                <div class="form-outline mb-2" style="width: 200px">
                  <label for="cinsiyet" class="form-label">Cinsiyet</label>
                  <input type="cinsiyet" id="cinsiyet" name="cinsiyet" class="form-control" value="<?php echo $cinsiyet; ?>" readonly>
                </div>

                <div class="form-outline mb-2">
                  <label class="form-label" for="email_txt">Email Adresi</label>
                  <input type="email" id="email_txt" name="email_txt" class="form-control" value="<?php echo $email; ?>" readonly required>
                </div>
                <button type="submit" class="btn btn-primary">Kaydet</button>
                <button type="submit" class="btn btn-danger" name="delete_profile" onclick="return confirm('Profilinizi silmek istediğinizden emin misiniz?')">Profili Sil</button>
              </form>
            </div>
          </div>
        </div>
      </div>

    <?php
    } else {
      echo "Kullanıcı bulunamadı.";
    }

    $conn->close();
    ?>


  </div>
  <script src="../js/script.js"></script>

  <script src="https://kit.fontawesome.com/f3e26a62cc.js" crossorigin="anonymous"></script>

 

</body>

</html>
