<?php
session_start();

// Veritabanına bağlan
$conn = mysqli_connect("localhost", "root", "", "dental");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Veritabanında e-postaya ait kullanıcıyı sorgula
$email = $_SESSION["email"];
$sql = "SELECT id FROM uyebilgileri_tablosu WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $selectedUserID = $row["id"];

    // Diğer işlemleri yapabilirsiniz...
    // Örneğin, veritabanına kaydedebilirsiniz veya başka bir eylem gerçekleştirebilirsiniz.

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selectedDoctorName = $_POST["doctor"]; // Seçilen doktorun adını alıyoruz
        $selectedDate = DateTime::createFromFormat('d/m/Y', $_POST["date"])->format('Y-m-d'); // Tarihi "d/m/Y" formatından "Y-m-d" formatına dönüştürüyoruz
        $selectedTime = $_POST["time"];

        // Seçilen doktorun ID'sini "doktorlar" tablosundan alıyoruz
        $sql = "SELECT id FROM doktorlar WHERE ad = '$selectedDoctorName'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $selectedDoctorID = $row["id"];

            // Önceden oluşturulmuş bir randevunun olup olmadığını kontrol et
            $sql = "SELECT * FROM randevular WHERE doktor_id = '$selectedDoctorID' AND user_id = '$selectedUserID' AND tarih = '$selectedDate' AND saat = '$selectedTime'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<script>alert("Bu randevu zaten oluşturulmuş."); window.location.href = "randevularım.php";</script>';
            } else {
                // Randevu tablosuna doktorun ID'sini, kullanıcının ID'sini, tarihi, saati ve durumu kaydet
                $sql = "INSERT INTO randevular (doktor_id, user_id, tarih, saat, ran_dur) VALUES ('$selectedDoctorID', '$selectedUserID', '$selectedDate', '$selectedTime', 'Onay Bekleniyor')";

                if ($conn->query($sql) === TRUE) {
                    echo '<script>alert("Randevu başarıyla oluşturuldu."); window.location.href = "randevularım.php";</script>';
                } else {
                    echo "Hata: " . $sql . "<br>" . $conn->error;
                }
            }
        } else {
            echo "Seçilen doktor bulunamadı.";
        }
    }
} else {
    echo "Giriş yapılan e-postaya ait kullanıcı bulunamadı.";
}

$conn->close();
?>
