<?php
ob_start();

require_once '../components/session.php';
include 'connection.php';

date_default_timezone_set('Europe/Istanbul');


if (isset($_POST['domainAdd'])) {
    $domain_customer = filter_input(INPUT_POST, 'domain_customer', FILTER_SANITIZE_STRING);
    $domain_name = filter_input(INPUT_POST, 'domain_name', FILTER_SANITIZE_STRING);
    $company_domain = filter_input(INPUT_POST, 'company_domain', FILTER_SANITIZE_STRING);
    $domain_start = filter_input(INPUT_POST, 'domain_start', FILTER_SANITIZE_STRING);
    $domain_end = filter_input(INPUT_POST, 'domain_end', FILTER_SANITIZE_STRING);
    $domain_price = filter_input(INPUT_POST, 'domain_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $hosting_company = filter_input(INPUT_POST, 'hosting_company', FILTER_SANITIZE_STRING);
    $hosting_start = filter_input(INPUT_POST, 'hosting_start', FILTER_SANITIZE_STRING);
    $hosting_end = filter_input(INPUT_POST, 'hosting_end', FILTER_SANITIZE_STRING);
    $automatic_mail = filter_input(INPUT_POST, 'automatic_mail', FILTER_SANITIZE_NUMBER_INT);
    $automatic_sms = filter_input(INPUT_POST, 'automatic_sms', FILTER_SANITIZE_NUMBER_INT);
    $hosting_price = filter_input(INPUT_POST, 'hosting_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    $automatic_mail = $automatic_mail ?? 0; 
    $automatic_sms = $automatic_sms ?? 0; 
    try {
        $stmt = $db->prepare("INSERT INTO domains (customer_id, domain_name, company_domain, domain_start, domain_end, domain_price, hosting_company, hosting_start, hosting_end, automatic_mail, automatic_sms, hosting_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $domain_customer,
            $domain_name,
            $company_domain,
            $domain_start,
            $domain_end,
            $domain_price,
            $hosting_company,
            $hosting_start,
            $hosting_end,
            $automatic_mail,
            $automatic_sms,
            $hosting_price
        ]);
        echo "<script>alert('Domain bilgileri başarıyla kaydedildi.'); window.location.href='../list_websites.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Hata: " . htmlspecialchars($e->getMessage()) . "'); window.history.back();</script>";
    }
}

if (isset($_POST['addCustomer'])) {
    $customer_name = filter_input(INPUT_POST, 'customer_name', FILTER_SANITIZE_STRING);
    $customer_phone = filter_input(INPUT_POST, 'customer_phone', FILTER_SANITIZE_STRING);
    $customer_mail = filter_input(INPUT_POST, 'customer_mail', FILTER_SANITIZE_EMAIL);
    try {
        $stmt = $db->prepare("INSERT INTO costumer (customer_name, customer_phone, customer_mail, is_delete) VALUES (:customer_name, :customer_phone, :customer_mail, 0)");
        $stmt->bindParam(':customer_name', $customer_name);
        $stmt->bindParam(':customer_phone', $customer_phone);
        $stmt->bindParam(':customer_mail', $customer_mail);
        $stmt->execute();
        echo "<script>alert('Müşteri başarıyla eklendi.'); window.location.href='../list_customers.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Hata: " . htmlspecialchars($e->getMessage()) . "'); window.history.back();</script>";
    }
} else {
}
if (isset($_POST['updateCustomer'])) {
    $customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_SANITIZE_NUMBER_INT);
    $customer_name = filter_input(INPUT_POST, 'customer_name', FILTER_SANITIZE_STRING);
    $customer_phone = filter_input(INPUT_POST, 'customer_phone', FILTER_SANITIZE_STRING);
    $customer_mail = filter_input(INPUT_POST, 'customer_mail', FILTER_SANITIZE_EMAIL);

    try {
        $stmt = $db->prepare("UPDATE costumer SET customer_name = :customer_name, customer_phone = :customer_phone, customer_mail = :customer_mail WHERE customer_id = :customer_id");
        $stmt->bindParam(':customer_name', $customer_name);
        $stmt->bindParam(':customer_phone', $customer_phone);
        $stmt->bindParam(':customer_mail', $customer_mail);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();
        echo "<script>alert('Müşteri bilgileri başarıyla güncellendi.'); window.location.href='../list_customers.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Hata: " . htmlspecialchars($e->getMessage()) . "'); window.history.back();</script>";
    }
} else {
}
if (isset($_POST['deleteCustomer'])) {
    $customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_SANITIZE_NUMBER_INT);

    if ($customer_id) {
        try {
            $stmt = $db->prepare("UPDATE costumer SET is_delete = 1 WHERE customer_id = :customer_id");
            $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
            $stmt->execute();
            echo "<script>alert('Müşteri kaydı başarıyla silindi.'); window.location.href='../list_customers.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Hata: " . htmlspecialchars($e->getMessage()) . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Geçersiz müşteri ID.'); window.history.back();</script>";
    }
} else {
}

if (isset($_POST['updateUsers'])) {
    $customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_SANITIZE_NUMBER_INT);
    $customer_name = filter_input(INPUT_POST, 'customer_name', FILTER_SANITIZE_STRING);
    $customer_phone = filter_input(INPUT_POST, 'customer_phone', FILTER_SANITIZE_STRING);
    $customer_mail = filter_input(INPUT_POST, 'customer_mail', FILTER_SANITIZE_EMAIL);
    $customer_password = filter_input(INPUT_POST, 'customer_password', FILTER_SANITIZE_STRING);
    $hashed_password = md5($customer_password);
    $stmt = $db->prepare("UPDATE users SET user_name = :customer_name, user_phone = :customer_phone, user_mail = :customer_mail, user_password = :hashed_password WHERE id = :customer_id");
    $stmt->bindParam(':customer_name', $customer_name, PDO::PARAM_STR);
    $stmt->bindParam(':customer_phone', $customer_phone, PDO::PARAM_STR);
    $stmt->bindParam(':customer_mail', $customer_mail, PDO::PARAM_STR);
    $stmt->bindParam(':hashed_password', $hashed_password, PDO::PARAM_STR);
    $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
    $stmt->execute();
    header("Location: list_customers.php?update=success");
    exit;
}

if (isset($_POST['save_domains'])) {
    $domain_ids = $_POST['domain_id'] ?? [];
    $customers = $_POST['customer'] ?? [];
    $start_dates = $_POST['start_date'] ?? [];
    $end_dates = $_POST['end_date'] ?? [];
    $hosting_prices = $_POST['hosting_price'] ?? [];
    $domain_prices = $_POST['domain_price'] ?? [];
    $adds = $_POST['add'] ?? [];
    $sms = $_POST['sms'] ?? [];
    $mails = $_POST['mail'] ?? [];
    $company_domains = $_POST['company_domain'] ?? [];
    for ($i = 0; $i < count($domain_ids); $i++) {
        if (isset($adds[$i])) { 
            $hosting_price = $hosting_prices[$i] ?? 0;
            $domain_price = $domain_prices[$i] ?? 0;
            $customer_id = $customers[$i] ?? '';
            if (!empty($customer_id)) {
                $customer_query = "SELECT customer_id FROM costumer WHERE customer_id = :customer_id";
                $stmt = $db->prepare($customer_query);
                $stmt->bindParam(':customer_id', $customer_id);
                $stmt->execute();
                $customer_id = $stmt->fetchColumn();
                if ($customer_id) {
                    $insert_query = "INSERT INTO domains (customer_id, domain_name, domain_start, domain_end, domain_price, automatic_mail, automatic_sms, is_delete, company_domain, hosting_company, hosting_start, hosting_end, hosting_price) 
                     VALUES (:customer_id, :domain_name, :start_date, :end_date, :domain_price, :automatic_mail, :automatic_sms, 0, :company_domain, :hosting_company, :hosting_start, :hosting_end, :hosting_price)";
                    $insert_stmt = $db->prepare($insert_query);
                    $automatic_mail = isset($mails[$i]) ? 1 : 0;
                    $automatic_sms = isset($sms[$i]) ? 1 : 0;
                    $domain_name = $all_domains[$i]['name'];
                    $start_date = $start_dates[$i];
                    $end_date = $end_dates[$i];
                    $domain_price = $domain_price;
                    $company_domain = $_POST['company_domain'];
                    $hosting_company = $host;
                    $hosting_start = $all_domains[$i]['created'] ?? date('Y-m-d');
                    $hosting_end = $all_domains[$i]['expirationDate'] ?? date('Y-m-d', strtotime('+1 year'));
                    var_dump($company_domain);
                    $insert_stmt->bindParam(':customer_id', $customer_id);
                    $insert_stmt->bindParam(':domain_name', $domain_name);
                    $insert_stmt->bindParam(':start_date', $start_date);
                    $insert_stmt->bindParam(':end_date', $end_date);
                    $insert_stmt->bindParam(':domain_price', $domain_price);
                    $insert_stmt->bindParam(':automatic_mail', $automatic_mail);
                    $insert_stmt->bindParam(':automatic_sms', $automatic_sms);
                    $insert_stmt->bindParam(':company_domain', $company_domain);
                    $insert_stmt->bindParam(':hosting_company', $hosting_company);
                    $insert_stmt->bindParam(':hosting_price', $hosting_price);
                    $insert_stmt->bindParam(':hosting_start', $hosting_start);
                    $insert_stmt->bindParam(':hosting_end', $hosting_end);
                    $insert_stmt->execute();
                }
            }
        }
    }

    echo "<script>alert('Kayıtlar başarıyla eklendi.');</script>"; 
}


if (isset($_POST['generalSettings'])) {
    $id = 1;
    $title = $_POST['title'];
    $description = $_POST['description'];
    $owner = $_POST['owner'];

    print($title);

    try {
        $stmt = $db->prepare("UPDATE settings SET title = :title, description = :description, owner = :owner WHERE id = :id");
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':owner', $owner, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        echo "<script>alert('Ayarlar Güncellendi'); window.location.href='../panel_settings.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Hata: " . htmlspecialchars($e->getMessage()) . "'); window.history.back();</script>";
    }
}


if (isset($_POST['mailSettings'])) {
    $id = 1;
    $mail_adress = $_POST['mail_adress'];
    $mail_password = $_POST['mail_password'];
    $host_adress = $_POST['host_adress'];
    $port_number = $_POST['port_number'];

    print($title);

    try {
        $stmt = $db->prepare("UPDATE settings SET mail_adress = :mail_adress, mail_password = :mail_password, host_adress = :host_adress, port_number = :port_number WHERE id = :id");
        $stmt->bindParam(':mail_adress', $mail_adress, PDO::PARAM_STR);
        $stmt->bindParam(':mail_password', $mail_password, PDO::PARAM_STR);
        $stmt->bindParam(':host_adress', $host_adress, PDO::PARAM_STR);
        $stmt->bindParam(':port_number', $port_number, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        echo "<script>alert('Ayarlar Güncellendi'); window.location.href='../panel_settings.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Hata: " . htmlspecialchars($e->getMessage()) . "'); window.history.back();</script>";
    }
}

if (isset($_POST['smsApi'])) {
    $id = 1;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $header = $_POST['header'];
    $message_template_1 = $_POST['message_template_1'];

    try {
        $stmt = $db->prepare("UPDATE settings SET sms_username = :username, sms_password = :password, sms_header = :header, message_template = :message_template WHERE id = :id");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':header', $header, PDO::PARAM_STR);
        $stmt->bindParam(':message_template', $message_template_1, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        echo "<script>alert('Ayarlar Güncellendi'); window.location.href='../panel_settings.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Hata: " . htmlspecialchars($e->getMessage()) . "'); window.history.back();</script>";
    }
}

if (isset($_POST['domainEdit'])) {
    $domain_id = filter_input(INPUT_POST, 'domain_id', FILTER_SANITIZE_NUMBER_INT);
    $customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_SANITIZE_NUMBER_INT);
    $domain_name = filter_input(INPUT_POST, 'domain_name', FILTER_SANITIZE_STRING);
    $company_domain = filter_input(INPUT_POST, 'company_domain', FILTER_SANITIZE_STRING);
    $domain_start = filter_input(INPUT_POST, 'domain_start', FILTER_SANITIZE_STRING);
    $domain_end = filter_input(INPUT_POST, 'domain_end', FILTER_SANITIZE_STRING);
    $domain_price = filter_input(INPUT_POST, 'domain_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    try {
        $stmt = $db->prepare("UPDATE domains SET customer_id = ?, domain_name = ?, company_domain = ?, domain_start = ?, domain_end = ?, domain_price = ? WHERE id = ?");
        $stmt->execute([
            $customer_id,
            $domain_name,
            $company_domain,
            $domain_start,
            $domain_end,
            $domain_price,
            $domain_id
        ]);

        echo "<script>alert('Domain bilgileri başarıyla güncellendi.'); window.location.href='../list_websites.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Hata: " . htmlspecialchars($e->getMessage()) . "'); window.history.back();</script>";
    }
}

if (isset($_POST['domainDelete'])) {
    $domain_id = filter_input(INPUT_POST, 'domain_id', FILTER_SANITIZE_NUMBER_INT);
    try {
        $stmt = $db->prepare("UPDATE domains SET is_delete = 1 WHERE id = ?");
        $stmt->execute([$domain_id]);

        echo "<script>alert('Domain başarıyla silindi.'); window.location.href='../list_websites.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Hata: " . htmlspecialchars($e->getMessage()) . "'); window.history.back();</script>";
    }
}


if (isset($_POST['deleteRegistrar'])) {
    $registrars_id = filter_input(INPUT_POST, 'registrars_id', FILTER_SANITIZE_NUMBER_INT);
    try {
        $stmt = $db->prepare("UPDATE registrars SET is_delete = 1 WHERE id = ?");
        $stmt->execute([$registrars_id]);
        echo "<script>alert('Domain başarıyla silindi.'); window.location.href='../registrars.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Hata: " . htmlspecialchars($e->getMessage()) . "'); window.history.back();</script>";
    }
}

if (isset($_POST['addRegistrars'])) {
    $company_name = $_POST['company_name'];
    $link = $_POST['link'];
    if (!empty($company_name) && !empty($link)) {
        try {
            $query = "INSERT INTO registrars (company_name, link, is_delete) VALUES (:company_name, :link, 0)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':company_name', $company_name);
            $stmt->bindParam(':link', $link);
            $stmt->execute();
            echo "<script>alert('Firma başarıyla eklendi.'); window.location.href = '../registrars.php';</script>"; 
        } catch (PDOException $e) {
            echo "<script>alert('Hata: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Lütfen tüm alanları doldurun.');</script>";
    }
}
