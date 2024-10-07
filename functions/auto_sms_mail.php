<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'SendSMS.php';
include 'connection.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function sendReminderSMS() {
    global $db;

    try {
        $today = date('Y-m-d');
        $query = $db->prepare("
        SELECT * FROM domains 
        WHERE domain_end BETWEEN :today AND DATE_ADD(:today, INTERVAL 10 DAY)
        AND automatic_sms = 1 
        AND is_delete = 0
    ");
        $query->bindParam(':today', $today);
        $query->execute();
        $domains = $query->fetchAll();
        echo "Sorgu Sonuçları:<br>";
        if (empty($domains)) {
            echo "10 gün içinde süresi dolacak domain bulunamadı.<br>";
        } else {
            foreach ($domains as $domain) {
                echo "Domain ID: " . $domain['id'] . "<br>";
                echo "Domain Adı: " . $domain['domain_name'] . "<br>";
                echo "Bitiş Tarihi: " . $domain['domain_end'] . "<br>";
                echo "<br>";
            }
        }
        $query = $db->prepare("SELECT * FROM sms_api_credentials WHERE id = 1");
        $query->execute();
        $smsData = $query->fetch();
        if (!$smsData) {
            throw new Exception('SMS ayarları bulunamadı.');
        }

        foreach ($domains as $domain) {
            $query = $db->prepare("SELECT * FROM costumer WHERE customer_id = :customer_id");
            $query->execute(['customer_id' => $domain['customer_id']]);
            $customer = $query->fetch();

            if (!$customer) {
                echo "Müşteri bilgileri bulunamadı. Müşteri ID: " . $domain['customer_id'];
                continue;
            }
            $domainEndDate = new DateTime($domain['domain_end']);
            $currentDate = new DateTime($today);
            $interval = $currentDate->diff($domainEndDate);
            $daysRemaining = $interval->days;
            if ($interval->invert) {
                $daysRemaining = -$daysRemaining;
            }
            echo "Domain: " . $domain['domain_name']. "<br>";
            echo "Müşteri: " . $customer['customer_name'] . "<br>";
            echo "Kalan Gün: " . $daysRemaining . "<br>";
            echo "<br>";
            $sms = new SendSMS();
            $sms->username = $smsData['username'];
            $sms->password = $smsData['password'];
            $sms->header = $smsData['header'];
            $sms->phone = $customer['customer_phone'];
            $sms->message = "Sayın " . $customer['customer_name'] . ", Websiteniz " . $domain['domain_name'] .  " süreniz " . $daysRemaining . " gün içinde dolacaktır bilgilerinize sunarız.";
            $sms->send();
        }
    } catch (Exception $e) {
        echo "Hata: " . $e->getMessage();
    }
}
function sendReminderSMSAdmin() {
    global $db;

    try {
        $today = date('Y-m-d');
        $query = $db->prepare("
        SELECT * FROM domains 
        WHERE domain_end BETWEEN :today AND DATE_ADD(:today, INTERVAL 10 DAY)
        AND automatic_sms = 1 
        AND is_delete = 0
    ");
        $query->bindParam(':today', $today);
        $query->execute();
        $domains = $query->fetchAll();
        echo "Sorgu Sonuçları:<br>";
        if (empty($domains)) {
            echo "10 gün içinde süresi dolacak domain bulunamadı.<br>";
        } else {
            foreach ($domains as $domain) {
                echo "Domain ID: " . $domain['id'] . "<br>";
                echo "Domain Adı: " . $domain['domain_name'] . "<br>";

                echo "Bitiş Tarihi: " . $domain['domain_end'] . "<br>";
                echo "<br>";
            }
        }
        $query = $db->prepare("SELECT * FROM sms_api_credentials WHERE id = 1");
        $query->execute();
        $smsData = $query->fetch();

        $query = $db->prepare("SELECT * FROM users WHERE id = 1");
        $query->execute();
        $userData = $query->fetch();
        if (!$smsData) {
            throw new Exception('SMS ayarları bulunamadı.');
        }
        foreach ($domains as $domain) {
            $query = $db->prepare("SELECT * FROM costumer WHERE customer_id = :customer_id");
            $query->execute(['customer_id' => $domain['customer_id']]);
            $customer = $query->fetch();

            if (!$customer) {
                echo "Müşteri bilgileri bulunamadı. Müşteri ID: " . $domain['customer_id'];
                continue;
            }
            $domainEndDate = new DateTime($domain['domain_end']);
            $currentDate = new DateTime($today);
            $interval = $currentDate->diff($domainEndDate);
            $daysRemaining = $interval->days;
            if ($interval->invert) {
                $daysRemaining = -$daysRemaining;
            }
            echo "Domain: " .$domain['domain_name'] . "<br>";
            echo "Müşteri: " . $customer['customer_name'] . "<br>";
            echo "Kalan Gün: " . $daysRemaining . "<br>";
            echo "<br>";
            $sms = new SendSMS();
            $sms->username = $smsData['username'];
            $sms->password = $smsData['password'];
            $sms->header = $smsData['header'];
            $sms->phone =  $userData['user_phone'];
            $sms->message = "Sayın " . $customer['customer_name'] . ", Websiteniz " . $domain['domain_name'] .  " süreniz " . $daysRemaining . " gün içinde dolacaktır bilgilerinize sunarız.";
            $sms->send();
        }
    } catch (Exception $e) {
        echo "Hata: " . $e->getMessage();
    }
}
function sendReminderEmail() {
    global $db;
    if (!$db) {
        die("Veritabanı bağlantısı başarısız.");
    }
    try {
        $today = date('Y-m-d');
        $query = $db->prepare("
            SELECT * FROM domains 
            WHERE domain_end BETWEEN :today AND DATE_ADD(:today, INTERVAL 10 DAY)
            AND automatic_mail = 1 
            AND is_delete = 0
        ");
        $query->bindParam(':today', $today);
        $query->execute();
        $domains = $query->fetchAll();
        if (empty($domains)) {
            echo "10 gün içinde süresi dolacak domain bulunamadı.<br>";
            return; 
        } else {
            echo count($domains) . " adet domain bulundu.<br>";
        }
        foreach ($domains as $domain) {
            $query = $db->prepare("SELECT * FROM costumer WHERE customer_id = :customer_id");
            $query->execute(['customer_id' => $domain['customer_id']]);
            $customer = $query->fetch();
            if (!$customer) {
                echo "Müşteri bilgileri bulunamadı. Müşteri ID: " . $domain['customer_id'] . "<br>";
                continue;
            } else {
                echo "Müşteri Adı: " . $customer['customer_name'] . "<br>";
            }
            $domainEndDate = new DateTime($domain['domain_end']);
            $currentDate = new DateTime($today);
            $interval = $currentDate->diff($domainEndDate);
            $daysRemaining = $interval->days;
            $settingsQuery = $db->prepare("SELECT * FROM settings WHERE id = 1");
            $settingsQuery->execute();
            $settingsData = $settingsQuery->fetch(PDO::FETCH_ASSOC);
            if (!$settingsData) {
                echo "Ayarlar bulunamadı.<br>";
                continue;
            } else {
                echo "Mail Adresi: " . $settingsData['mail_adress'] . "<br>";
                echo "Host Adresi: " . $settingsData['host_adress'] . "<br>";
                echo "Port Numarası: " . $settingsData['port_number'] . "<br>";
            }
            $mailAdress = $settingsData['mail_adress'];
            $mailPassword = $settingsData['mail_password'];
            $hostAdress = $settingsData['host_adress'];
            $portNumber = $settingsData['port_number'];
            $siteTitle = $settingsData['title']; 

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = $hostAdress;
                $mail->SMTPAuth = true;
                $mail->Username = $mailAdress;
                $mail->Password = $mailPassword;
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                $mail->Port = $portNumber;
                $mail->setFrom($mailAdress, $siteTitle);
                $mail->addAddress($customer['customer_mail']); 
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8'; 
                $mail->Subject = 'Domain Bildirimi';
                $mail->Body = "Sayın " . $customer['customer_name'] . ", Websiteniz " . $domain['domain_name'] .  " süreniz " . $daysRemaining . " gün içinde dolacaktır bilgilerinize sunarız.";

                if ($mail->send()) {
                    echo '<div class="alert alert-success">Mail başarıyla gönderildi: ' . $customer['customer_mail'] . '</div>';
                } else {
                    echo '<div class="alert alert-danger">Mail gönderme başarısız oldu.</div>';
                }
            } catch (Exception $e) {
                echo '<div class="alert alert-danger">Mail gönderme başarısız oldu: ' . $mail->ErrorInfo . '</div>';
            }
        }
    } catch (Exception $e) {
        echo "Hata: " . $e->getMessage();
    }
}

sendReminderEmail();
sendReminderSMS();
sendReminderSMSAdmin();