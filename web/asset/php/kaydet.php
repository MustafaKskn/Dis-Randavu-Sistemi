<?php
error_reporting(E_ALL);

// Veritabanı bağlantısı için gerekli bilgileri ayarlayın
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dental";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS uyebilgileri_tablosu (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ad VARCHAR(30) NOT NULL,
    surname VARCHAR(30) NOT NULL,
    telefon VARCHAR(15) NOT NULL,
    cinsiyet VARCHAR(10) NOT NULL,
    email VARCHAR(50) NOT NULL,
    sifre VARCHAR(50) NOT NULL
)";

if ($conn->query($sql) === FALSE) {
    echo "Tablo oluşturma hatası: " . $conn->error;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $telefon = $_POST['telefon'];
    $cinsiyet = $_POST['cinsiyet'];
    $email = $_POST['email_txt'];
    $password = $_POST['password_txt'];

    // Telefon numarası ve e-posta adresinin var olup olmadığını kontrol etmek için sorguları hazırlayın
    $telefonCheckQuery = "SELECT id FROM uyebilgileri_tablosu WHERE telefon = '$telefon'";
    $emailCheckQuery = "SELECT id FROM uyebilgileri_tablosu WHERE email = '$email'";

    // Sorguları veritabanında çalıştırın
    $telefonResult = $conn->query($telefonCheckQuery);
    $emailResult = $conn->query($emailCheckQuery);

    // Telefon numarası veya e-posta adresi zaten kayıtlıysa hata mesajı göster
    if ($telefonResult->num_rows > 0) {
        echo '<script>alert("Bu telefon numarası zaten kayıtlı."); window.location.href = "./kayıtol.html";</script>';
    } elseif ($emailResult->num_rows > 0) {
        echo '<script>alert("Bu e-posta adresi zaten kayıtlı."); window.location.href = "./kayıtol.html";</script>';
    } else {
        // Telefon numarası ve e-posta adresi daha önce kaydedilmemişse, verileri ekleyin
        $insertQuery = "INSERT INTO uyebilgileri_tablosu (ad, surname, telefon, cinsiyet, email, sifre)
                        VALUES ('$name', '$surname', '$telefon', '$cinsiyet', '$email', '$password')";

        if ($conn->query($insertQuery) === TRUE) {
            echo '<script>alert("Veriler başarıyla eklendi."); window.location.href = "../../index.html";</script>';
        } else {
            echo '<script>alert("Veri ekleme hatası: ' . json_encode($conn->error) . '");</script>';
        }
    }
}

$conn->close();
?>
