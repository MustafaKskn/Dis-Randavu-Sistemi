<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css"  href="../css/style3.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet"
      href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
  <link rel="icon" href="../images/ikon.webp">
    <title> Randevu Al</title>
    <script>
  $(function() {
    var currentStep = 1;
    var totalSteps = $('.step').length;

    $('.step-buttons .next').click(function() {
      var formValid = true;
      var currentForm = $('.step.active-step form');

      // Form validation
      currentForm.find('input, select').each(function() {
        if ($(this).prop('required') && $(this).val() === '') {
          formValid = false;
          $(this).addClass('error');
        } else {
          $(this).removeClass('error');
        }
      });

      if (formValid) {
        currentForm.removeClass('active-step');
        $('.step-' + (currentStep + 1)).addClass('active-step');
        currentStep++;
      }
    });

    $('.step-buttons .prev').click(function() {
      if (currentStep > 1) {
        $('.step.active-step').removeClass('active-step');
        $('.step-' + (currentStep - 1)).addClass('active-step');
        currentStep--;
      }
    });

    $("#date").datepicker({
      dateFormat: "dd/mm/yy"
    });

    var hours = [];
    for (var i = 9; i <= 17; i++) {
      hours.push((i < 10 ? '0' : '') + i + ':00');
    }

    $.each(hours, function(index, value) {
      $("#time").append('<option value="' + value + '">' + value + '</option>');
    });

    $('.doctor-selection input[type="radio"]').change(function() {
      $('.step-1 .step-buttons').show();
    });

    $('.doctor-selection .btn-select-doctor').click(function() {
      var doctorName = $(this).data('doctor-name');
      $('#selected-doctor').val(doctorName);
      $('.step-1').removeClass('active-step');
      $('.step-3').addClass('active-step'); // Modified step class
      currentStep = 3; // Updated current step
    });
  });
</script>
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
    <div class="container">
    <h2>Özel Diş Polikliniği Randevu Formu</h2>

    <div class="step step-1 active-step">
      <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "dental";

      $conn = new mysqli($servername, $username, $password, $dbname);

      if ($conn->connect_error) {
          die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
      }

      // Doktorları veritabanından sorgula ve tablo olarak görüntüle
      $sql = "SELECT * FROM doktorlar";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          echo "<table>
                <thead>
                  <tr>
                    <th>Doktor Adı</th>
                    <th>Uzmanlık Alanı</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class='doctor-selection'>";

          while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>" . $row["ad"] . "</td>
                      <td>" . $row["uzmanlik_alani"] . "</td>
                      <td><button class='btn btn-select-doctor' data-doctor-name='" . $row["ad"] . "'>Seç</button></td>
                    </tr>";
          }

          echo "</tbody>
                </table>";
      } else {
          echo "Doktor bulunamadı.";
      }

      $conn->close();
      ?>
    </div>
    <div class="step step-3">
    <form action="userrankay.php" method="post">
        <div class="form-group">
          <label for="date">Randevu Tarihi:</label>
          <input type="text" id="date" name="date" required>
        </div>
        <div class="form-group">
          <label for="time">Randevu Saati:</label>
          <select id="time" name="time" required>
            <option value="" disabled selected>Saat seçin</option>
          </select>
        </div>
        <input type="hidden" id="selected-doctor" name="doctor" value="">
        <div class="step-buttons">
          <button class="btn prev">Geri</button>
          <input type="submit" class="btn next" value="Randevu Al">
        </div>
      </form>
    </div>

    <div class="step step-4">
      <p>Randevunuz başarıyla oluşturuldu.</p>
    </div>
  </div>
    <script src="../js/script.js"></script>

    <script src="https://kit.fontawesome.com/f3e26a62cc.js"
      crossorigin="anonymous"></script>

  </body>
</html>