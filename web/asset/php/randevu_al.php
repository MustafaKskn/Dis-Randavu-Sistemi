<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="icon" href="../images/ikon.webp">
    <title> Randevu Al</title>
  <style>
    .container {
      max-width: 400px;
      margin: 0 auto;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-weight: bold;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    .step {
      display: none;
    }

    .active-step {
      display: block;
    }

    .step-buttons {
      display: flex;
      justify-content: space-between;
    }

    .btn {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #45a049;
    }
  </style>
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
        $('.step-2').addClass('active-step');
        currentStep = 2;
      });
    });
  </script>
</head>
<body>
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
    <div class="step step-2">
      <form>
        <div class="form-group">
          <label for="name">Ad:</label>
          <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
          <label for="surname">Soyad:</label>
          <input type="text" id="surname" name="surname" required>
        </div>
        <div class="form-group">
          <label for="email">E-posta:</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="phone">Telefon:</label>
          <input type="tel" id="phone" name="phone" required>
        </div>
      </form>
      <div class="step-buttons">
        <button class="btn prev">Geri</button>
        <button class="btn next">Devam</button>
      </div>
    </div>

    <div class="step step-3">
      <form >
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
</body>

</html> 

