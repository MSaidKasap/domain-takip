<!DOCTYPE html>
<html lang="tr">

<head>
    <?php require_once 'components/header.php'; ?>
    <style>
        .responsive-table {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            border-collapse: collapse;
        }

        .responsive-table th,
        .responsive-table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .responsive-table tr:hover {
            background-color: #f1f1f1;
        }

        @media screen and (max-width: 568px) {
            .responsive-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php
        require_once 'components/sidebar.php';
        require_once 'functions/connection.php';
        ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="card-body" style="width: 100%">
                            <div class="table-responsive">
                                <?php
                                require_once 'functions/connection.php';

                                $customers_query = "SELECT customer_name, customer_id FROM costumer";
                                $customers_stmt = $db->query($customers_query);
                                $customers = $customers_stmt->fetchAll(PDO::FETCH_ASSOC);

                                $cpanel_query = "SELECT * FROM cpanel";
                                $cpanel_stmt = $db->query($cpanel_query);
                                $cpanel_servers = $cpanel_stmt->fetchAll(PDO::FETCH_ASSOC);

                                $all_domains = [];
                                foreach ($cpanel_servers as $cpanel) {

                                    $host = $cpanel['host'];
                                    $port = $cpanel['port'];
                                    $username = $cpanel['username'];
                                    $token = $cpanel['password'];
                                    $query = "https://{$host}:{$port}/json-api/listaccts";
                                    $curl = curl_init();
                                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1); // Üretim ortamında bu değeri 1 yapın
                                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
                                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

                                    $header[] = "Authorization: Basic " . base64_encode("$username:$token");
                                    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                                    curl_setopt($curl, CURLOPT_URL, $query);

                                    $result = curl_exec($curl);
                                    if ($result === false) {
                                        echo "cURL Error: " . curl_error($curl);
                                    } else {
                                        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                                        if ($httpCode != 200) {
                                            echo "HTTP Error: $httpCode - " . htmlspecialchars($result);
                                        } else {
                                            $response = json_decode($result, true);
                                            if (isset($response['cpanelresult']['error'])) {
                                                echo "Hata: " . htmlspecialchars($response['cpanelresult']['error']);
                                            } else {
                                                print_r($response); 
                                            }
                                        }
                                    }
                               
                            
                                }
                                echo "
                                <h1>Domain Listesi (cPanel)</h1>
                                <form action='' method='post'>
                                <table class='responsive-table'>
                                    <tr>
                                        <th>Müşteri</th>
                                        <th>Domain</th>
                                        <th>Kayıt</th>
                                        <th>D Başlangıç</th>
                                        <th>D Bitiş</th>
                                        <th>D Fiyat</th>
                                        <th>H Fiyat</th>
                                        <th>Mail</th>
                                        <th>Sms</th>
                                        <th>Ekle</th>
                                    </tr>";

                                if (!empty($all_domains)) {
                                    foreach ($all_domains as $index => $domain) {
                                        echo "<tr>
                                        <input type='hidden' name='domain_id[]' value='" . htmlspecialchars($domain['id']) . "'>
                                        <td><select name='customer[]' class='form-control' style='width: 90px;'>";

                                        foreach ($customers as $customer) {
                                            echo "<option value='" . htmlspecialchars($customer['customer_id']) . "'>" . htmlspecialchars($customer['customer_name']) . "</option>";
                                        }

                                        echo "</select></td>
                                        <td style='width: 80px;'>" . htmlspecialchars($domain['name']) . "</td>          
                                        <td>
                                            <div class='form-group col-md-3'>
                                                <select id='company_list' class='form-control' name='company_domain[]' style='width: 100px;'>";

                                        $company = $db->prepare("SELECT * FROM registrars");
                                        $company->execute();
                                        while ($companypull = $company->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='" . htmlspecialchars($companypull['company_name']) . "'>" . htmlspecialchars($companypull['company_name']) . "</option>";
                                        }

                                        echo "</select>
                                            </div>
                                        </td>
                                        <td><input type='date' name='start_date[]' class='form-control' style='width: 80px;' value='" . date('Y-m-d', strtotime($domain['created'])) . "'></td>
                                        <td><input type='date' name='end_date[]' class='form-control' style='width: 80px;'></td>
                                        <td><input type='number' step='0.01' name='domain_price[]' class='form-control' style='width: 80px;'></td>
                                        <td><input type='number' step='0.01' name='hosting_price[]' class='form-control' style='width: 80px;'></td>
                                        <td><input type='checkbox' name='mail[$index]' value='1'></td>
                                        <td><input type='checkbox' name='sms[$index]' value='1'></td>
                                        <td><input type='checkbox' name='add[$index]' value='1'></td>
                                    </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='10'>Hiç domain bulunamadı.</td></tr>";
                                }

                                echo "</table>
                                <button type='submit' name='save_domains'>Kaydet</button>
                                </form>";

                                // Veritabanına kaydetme işlemi
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
                                                    $company_domain = $company_domains[$i];
                                                    $hosting_company = $cpanel_servers[0]['host']; 
                                                    $hosting_start = $all_domains[$i]['created'];
                                                    $hosting_end = date('Y-m-d', strtotime('+1 year', strtotime($hosting_start)));

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
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require_once 'components/csbar.php';
        require_once 'components/footer.php';
        require_once 'components/js.php';
        ?>
    </div>
</body>

</html>