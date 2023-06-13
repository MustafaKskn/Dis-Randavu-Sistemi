-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 11 Haz 2023, 01:59:41
-- Sunucu sürümü: 10.4.28-MariaDB
-- PHP Sürümü: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `dental`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `doktorlar`
--

CREATE TABLE `doktorlar` (
  `id` int(11) NOT NULL,
  `ad` varchar(50) DEFAULT NULL,
  `uzmanlik_alani` varchar(50) DEFAULT NULL,
  `Doktor_adres` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `doktorlar`
--

INSERT INTO `doktorlar` (`id`, `ad`, `uzmanlik_alani`, `Doktor_adres`) VALUES
(1, 'Dr. Ayşe Demir', 'Diş Hekimi', NULL),
(2, 'Dr. Mehmet Kaya', 'Ortodontist', NULL),
(3, 'Dr. Ahmet Yılmaz', 'Periodontolog', NULL),
(4, 'Dr. Fatma Aksoy', 'Çocuk Diş Hekimi', NULL),
(5, 'Dr. Ali Can', 'Endodontist', NULL),
(6, 'Dr. Zeynep Şahin', 'Oral ve Maxillofacial Cerrah', NULL),
(7, 'Dr. Mustafa Yıldız', 'Protodontist', NULL),
(8, 'Dr. Selma Karahan', 'Estetik Diş Hekimi', NULL),
(9, 'Dr. Burak Demirci', 'Periodontolog', NULL),
(10, 'Dr. Aylin Öztürk', 'Endodontist', NULL),
(11, 'Mustafa', 'Bilgisayar Programcısı', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `randevular`
--

CREATE TABLE `randevular` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `doktor_id` int(11) DEFAULT NULL,
  `tarih` date DEFAULT NULL,
  `saat` time DEFAULT NULL,
  `ran_dur` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uyebilgileri_tablosu`
--

CREATE TABLE `uyebilgileri_tablosu` (
  `id` int(6) UNSIGNED NOT NULL,
  `ad` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `cinsiyet` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sifre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `uyebilgileri_tablosu`
--

INSERT INTO `uyebilgileri_tablosu` (`id`, `ad`, `surname`, `telefon`, `cinsiyet`, `email`, `sifre`) VALUES
(26, 'Mustafa', 'Keskin', '05367878092', 'erkek', 'mustafakeskin@gmail.com', '1');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `doktorlar`
--
ALTER TABLE `doktorlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `randevular`
--
ALTER TABLE `randevular`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `doktor_id` (`doktor_id`);

--
-- Tablo için indeksler `uyebilgileri_tablosu`
--
ALTER TABLE `uyebilgileri_tablosu`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `doktorlar`
--
ALTER TABLE `doktorlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `randevular`
--
ALTER TABLE `randevular`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Tablo için AUTO_INCREMENT değeri `uyebilgileri_tablosu`
--
ALTER TABLE `uyebilgileri_tablosu`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `randevular`
--
ALTER TABLE `randevular`
  ADD CONSTRAINT `randevular_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `uyebilgileri_tablosu` (`id`),
  ADD CONSTRAINT `randevular_ibfk_2` FOREIGN KEY (`doktor_id`) REFERENCES `doktorlar` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
