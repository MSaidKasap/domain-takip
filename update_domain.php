<?php
require_once 'functions/connection.php';


// Form verilerini al
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Gelen verileri al
    $domain_ids = $_POST['domain_id'] ?? [];
    $customers = $_POST['customer'] ?? [];
    $start_dates = $_POST['start_date'] ?? [];
    $end_dates = $_POST['end_date'] ?? [];
    $prices = $_POST['price'] ?? [];
    $add_flags = $_POST['add'] ?? [];
    $sms_flags = $_POST['sms'] ?? [];
    $mail_flags = $_POST['mail'] ?? [];
    
    // Veritabanına bağlan
    try {
        $db->beginTransaction(); // İşlemi başlat

        // Domainleri döngüye al
        foreach ($domain_ids as $index => $domain_id) {
            // Eğer 'add' checkbox'ı işaretlendiyse
            if (isset($add_flags[$index]) && $add_flags[$index] == '1') {
                $customer = $customers[$index];
                $start_date = $start_dates[$index];
                $end_date = $end_dates[$index];
                $price = $prices[$index];
                $automatic_mail = isset($mail_flags[$index]) ? 1 : 0;
                $automatic_sms = isset($sms_flags[$index]) ? 1 : 0;

                // Veritabanına ekleme sorgusu
                $stmt = $db->prepare("
                    INSERT INTO domains (customer_id, domain_name, domain_start, domain_end, domain_price, automatic_mail, automatic_sms)
                    VALUES (
                        (SELECT id FROM costumer WHERE customer_name = :customer),
                        :domain_name,
                        :start_date,
                        :end_date,
                        :price,
                        :automatic_mail,
                        :automatic_sms
                    )
                ");

                // Parametreleri bağla
                $stmt->bindParam(':customer', $customer);
                $stmt->bindParam(':domain_name', $domain_id); // Burada domain adını doğru almanız gerek
                $stmt->bindParam(':start_date', $start_date);
                $stmt->bindParam(':end_date', $end_date);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':automatic_mail', $automatic_mail);
                $stmt->bindParam(':automatic_sms', $automatic_sms);

                // Sorguyu çalıştır
                $stmt->execute();
            }
        }

        $db->commit(); // İşlemi onayla
        echo "Domainler başarıyla kaydedildi.";
    } catch (PDOException $e) {
        $db->rollBack(); // Hata olursa işlemi geri al
        echo "Hata: " . $e->getMessage();
    }
}
?>
