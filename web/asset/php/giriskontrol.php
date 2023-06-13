<?php
session_start();

// Veritabanı bağlantısı yapılacak bilgileri güncelleyin
/*$servername = "localhost";
$username = "mustafa";
$password = "mustafa1903";
$dbname = "dental";*/

// POST isteğinden email ve şifre değerlerini alın
$email = $_POST["email"];
$password = $_POST["password"];

// Veritabanına bağlan
$conn = mysqli_connect("localhost", "root", "", "dental");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Kullanıcı giriş bilgilerini kontrol et
$sql = "SELECT * FROM uyebilgileri_tablosu WHERE email = '$email' AND sifre = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Giriş başarılı, oturum aç
    $_SESSION["email"] = $email;
    $_SESSION["password"] = $password;

    // userrankay.php'ye POST isteği göndermek için curl kullanımı2
    $url = 'http://www.example.com/userrankay.php'; // userrankay.php dosyasının URL'sini buraya girin
    $postData = array(
        'email' => $email // Göndermek istediğiniz verileri burada belirtin
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);
    // userrankay.php'ye POST isteği göndermek için curl kullanımı3
    $url = 'http://www.example.com/profil.php'; // userrankay.php dosyasının URL'sini buraya girin
    $postData = array(
        'email' => $email // Göndermek istediğiniz verileri burada belirtin
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    // userrankay.php'ye POST isteği göndermek için curl kullanımı
    $url = 'http://www.example.com/randevularım.php'; // userrankay.php dosyasının URL'sini buraya girin
    $postData = array(
        'email' => $email // Göndermek istediğiniz verileri burada belirtin
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    header('Location: ../php/dashboard.php');
} else {
    // Kullanıcı veritabanında yoksa veya e-posta veya şifre hatalıysa ilgili hataları göster
    $sql_check_user = "SELECT * FROM uyebilgileri_tablosu WHERE email = '$email'";
    $result_check_user = $conn->query($sql_check_user);

    if ($result_check_user->num_rows > 0) {
        echo '<script>alert("Şifre hatalı. Tekrar deneyiniz.");</script>';
    } else {
        echo '<script>alert("Kullanıcı bulunamadı. Tekrar deneyiniz.");</script>';
    }

    echo '<script>window.location.href = "./login.php";</script>';
}

$conn->close();
?>
