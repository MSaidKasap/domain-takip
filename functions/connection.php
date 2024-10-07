<?php 
$host = "localhost"; // Host adınızı girin. Varsayılan olarak Localhost'tur, eğer bilginiz yoksa bu şekilde bırakın.
$veritabani_ismi = "admin_domain"; // Veritabanı İsminiz
$kullanici_adi = "root"; // Veritabanı kullanıcı adınız
$sifre = "root"; // Kullanıcı şifreniz

try {
    $db = new PDO("mysql:host=$host;dbname=$veritabani_ismi;charset=utf8", $kullanici_adi, $sifre);
    // echo "Veritabanı bağlantısı başarılı";
} catch (PDOException $e) { // Burada 'PDOException' olmalıydı.
    echo "Veritabanı bağlantısı başarısız: " . $e->getMessage();
}

