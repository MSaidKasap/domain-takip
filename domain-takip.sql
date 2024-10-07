-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:8889
-- Üretim Zamanı: 07 Eki 2024, 08:14:45
-- Sunucu sürümü: 8.0.35
-- PHP Sürümü: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `admin_domain`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `costumer`
--

CREATE TABLE `costumer` (
  `customer_id` int NOT NULL,
  `customer_name` varchar(400) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `customer_phone` varchar(400) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `customer_mail` varchar(400) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `is_delete` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cpanel`
--

CREATE TABLE `cpanel` (
  `id` int NOT NULL,
  `host` varchar(255) NOT NULL,
  `port` int NOT NULL,
  `protocol` varchar(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo için tablo yapısı `domains`
--

CREATE TABLE `domains` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `domain_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `company_domain` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `domain_start` date NOT NULL,
  `domain_end` date NOT NULL,
  `domain_price` decimal(10,2) NOT NULL,
  `hosting_company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hosting_start` date NOT NULL,
  `hosting_end` date NOT NULL,
  `automatic_mail` tinyint(1) NOT NULL DEFAULT '0',
  `automatic_sms` tinyint(1) NOT NULL DEFAULT '0',
  `hosting_price` decimal(10,2) NOT NULL,
  `is_delete` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


--
-- Tablo için tablo yapısı `email_api_credentials`
--

CREATE TABLE `email_api_credentials` (
  `id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `header` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `message_template` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `plesk`
--

CREATE TABLE `plesk` (
  `id` int NOT NULL,
  `host` varchar(255) NOT NULL,
  `port` int NOT NULL,
  `protocol` varchar(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


--
-- Tablo için tablo yapısı `registrars`
--

CREATE TABLE `registrars` (
  `id` int NOT NULL,
  `company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_delete` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `registrars`
--

INSERT INTO `registrars` (`id`, `company_name`, `link`, `is_delete`) VALUES
(1, 'GoDaddy', 'https://www.godaddy.com', 0),
(2, 'Namecheap', 'https://www.namecheap.com', 0),
(3, 'Google Domains', 'https://domains.google.com', 0),
(4, 'Bluehost', 'https://www.bluehost.com', 0),
(5, 'HostGator', 'https://www.hostgator.com', 0),
(6, 'Domain.com', 'https://www.domain.com', 0),
(7, 'Hover', 'https://www.hover.com', 0),
(8, '1&1 IONOS', 'https://www.ionos.com', 0),
(9, 'Dynadot', 'https://www.dynadot.com', 0),
(10, 'Gandi', 'https://www.gandi.net', 0),
(11, 'Name.com', 'https://www.name.com', 0),
(12, 'İsimtescil', 'https://www.isimtescil.net/', 0),
(13, 'DİLARA BİLGİSAYAR', 'https://dilarabilgisayar.net/', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `session_data`
--

CREATE TABLE `session_data` (
  `id` int NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `user_id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `link` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `title` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `description` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `owner` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `logo` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `site_mail` varchar(250) NOT NULL,
  `host_adress` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `port_number` int NOT NULL,
  `mail_adress` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `mail_password` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `sms_name` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `sms_password` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


--
-- Tablo için tablo yapısı `sms_api_credentials`
--

CREATE TABLE `sms_api_credentials` (
  `id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `header` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `message_template` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `user_name` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `user_mail` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `user_phone` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `user_password` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `is_delete` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;



--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `costumer`
--
ALTER TABLE `costumer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Tablo için indeksler `cpanel`
--
ALTER TABLE `cpanel`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `domains`
--
ALTER TABLE `domains`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `plesk`
--
ALTER TABLE `plesk`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `registrars`
--
ALTER TABLE `registrars`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `session_data`
--
ALTER TABLE `session_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_id` (`session_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `sms_api_credentials`
--
ALTER TABLE `sms_api_credentials`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `costumer`
--
ALTER TABLE `costumer`
  MODIFY `customer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `cpanel`
--
ALTER TABLE `cpanel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `domains`
--
ALTER TABLE `domains`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `plesk`
--
ALTER TABLE `plesk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `registrars`
--
ALTER TABLE `registrars`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tablo için AUTO_INCREMENT değeri `session_data`
--
ALTER TABLE `session_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `sms_api_credentials`
--
ALTER TABLE `sms_api_credentials`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `session_data`
--
ALTER TABLE `session_data`
  ADD CONSTRAINT `session_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
