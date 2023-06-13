<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style2.css">
    
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
      crossorigin="anonymous">

    <link rel="stylesheet"
      href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
      <link rel="icon" href="../images/ikon.webp">

    <title>Randevularım</title>
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
    <div class="tablearka">
  <table class="table my-1" style="background-color: var(--primary-color);">
    <thead class="table-dark">
      <tr>
        <th scope="col">No</th>
        <th scope="col">AD-SOYAD</th>
        <th scope="col">DOKTOR ADI</th>
        <th scope="col">DOKTOR ALANI</th>
        <th scope="col">Randevu Tarihi</th>
        <th scope="col">Randevu Saati</th>
        <th scope="col">RANDEVU DURUM</th>
        <th scope="col">Sil</th>
      </tr>
    </thead>
    <tbody>
    <?php
session_start();
$email = $_SESSION["email"];

// Veritabanına bağlan
$conn = mysqli_connect("localhost", "root", "", "dental");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET["delete"])) {
    $appointmentID = $_GET["delete"];

    // Randevuyu sil
    $sql = "DELETE FROM randevular WHERE id = '$appointmentID'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION["appointment_deleted"] = true;
        header("Location: randevularım.php");
        exit();
    } else {
        echo "Randevu silinirken bir hata oluştu: " . mysqli_error($conn);
    }
}

if (isset($_SESSION["appointment_deleted"])) {
    echo "<script>alert('Randevu başarıyla silindi.');</script>";
    unset($_SESSION["appointment_deleted"]);
}

// Randevu tarih ve saatini güncelle
if (isset($_POST["update"])) {
    $appointmentID = $_POST["appointment_id"];
    $newDate = $_POST["new_date"];
    $newTime = $_POST["new_time"];

    $sql = "UPDATE randevular SET tarih = '$newDate', saat = '$newTime' WHERE id = '$appointmentID'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Randevu başarıyla güncellendi.');</script>";
    } else {
        echo "Randevu güncellenirken bir hata oluştu: " . mysqli_error($conn);
    }
}

// Kullanıcının ID'sini sorgula
$sql = "SELECT id FROM uyebilgileri_tablosu WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $selectedUserID = $row["id"];

    // Kullanıcının randevularını ve ilgili doktor bilgilerini sorgula
    $sql = "SELECT randevular.id, uyebilgileri_tablosu.ad AS kullanici_ad, doktorlar.ad AS doktor_ad, doktorlar.uzmanlik_alani AS alan, randevular.tarih, randevular.saat, randevular.ran_dur
            FROM randevular
            INNER JOIN uyebilgileri_tablosu ON randevular.user_id = uyebilgileri_tablosu.id
            INNER JOIN doktorlar ON randevular.doktor_id = doktorlar.id
            WHERE uyebilgileri_tablosu.id = '$selectedUserID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th scope='row' style='background-color: var(--primary-color);'>" . $row["id"] . "</th>";
            echo "<td>" . $row["kullanici_ad"] . "</td>";
            echo "<td>" . $row["doktor_ad"] . "</td>";
            echo "<td>" . $row["alan"] . "</td>";
            echo "<td>" . $row["tarih"] . "</td>";
            echo "<td>" . $row["saat"] . "</td>";
            echo "<td>" . $row["ran_dur"] . "</td>";
            echo "<td>";
            echo "<a href='?delete=" . $row["id"] . "' class='btn btn-danger' onclick='return confirm(\"Randevuyu silmek istediğinize emin misiniz?\");'><i class='far fa-trash-alt'></i></a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>Randevu bulunamadı.</td></tr>";
    }
} else {
    echo "<tr><td colspan='8'>Kullanıcı bulunamadı.</td></tr>";
}

$conn->close();
?>


    </tbody>
  </table>
</div>
    <script src="../js/script.js"></script>

    <script src="https://kit.fontawesome.com/f3e26a62cc.js"
      crossorigin="anonymous"></script>

  </body>
</html>