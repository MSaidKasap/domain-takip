<!DOCTYPE html>
<html lang="tr">

<head>
    <?php 
        require_once 'components/sidebar.php';require_once 'components/header.php'; ?>
</head>
<style>
.no-domains-message {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-size: 24px;
    color: green;
}

</style>
<link rel="stylesheet" href="dist/css/adminlte.css">

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php

    require_once 'functions/connection.php';
    require_once 'components/navbar.php';
    ?>

        <?php
    function getMusteriAdi($customer_id, $db)
    {
      $customersql = $db->prepare("SELECT customer_name FROM costumer WHERE customer_id = :id");
      $customersql->execute(array('id' => $customer_id));
      $customerpull = $customersql->fetch(PDO::FETCH_ASSOC);
      return htmlspecialchars($customerpull['customer_name'] ?? 'Müşteri Bulunamadı');
    }
    ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="card-body" style="width: 100%">
                            <div class="table-responsive">
                                <?php
                $domainsql = $db->prepare("SELECT * FROM domains WHERE is_delete = 0 AND DATEDIFF(domain_end, CURDATE()) < 60");
                $domainsql->execute();
                $domainlist = $domainsql->fetchAll(PDO::FETCH_ASSOC);

                if (count($domainlist) > 0) { 
                ?>
                                <table class="table table-bordered pt-4" id="domaintablosu" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Domain Adı</th>
                                            <th>Müşteri</th>
                                            <th>Domain Bitiş</th>
                                            <th>Kalan Gün Sayısı</th>
                                            <th>Otomatik Mail</th>
                                            <th>Otomatik SMS</th>
                                            <th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($domainlist as $domain) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($domain['id'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($domain['domain_name'] ?? ''); ?></td>
                                            <td><?php echo getMusteriAdi($domain['customer_id'] ?? '', $db); ?></td>
                                            <td><?php echo htmlspecialchars($domain['domain_end'] ?? ''); ?></td>
                                            <td><?php echo floor((strtotime($domain['domain_end']) - strtotime(date('Y-m-d'))) / (60 * 60 * 24)); ?>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="customSwitch<?php echo $domain['id']; ?>"
                                                        <?php echo $domain['automatic_mail'] == 1 ? 'checked' : ''; ?>
                                                        disabled>
                                                    <label class="custom-control-label"
                                                        for="customSwitch<?php echo $domain['id']; ?>">Mail</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="customSwitch<?php echo $domain['id']; ?>"
                                                        <?php echo $domain['automatic_sms'] == 1 ? 'checked' : ''; ?>
                                                        disabled>
                                                    <label class="custom-control-label"
                                                        for="customSwitch<?php echo $domain['id']; ?>">SMS</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <form action="edit_domain.php" method="POST">
                                                        <input type="hidden" name="domain_id"
                                                            value="<?php echo htmlspecialchars(string: $domain['id'] ?? ''); ?>">
                                                        <button type="submit" name="edit"
                                                            class="btn btn-success btn-sm btn-icon-split">
                                                            <span class="icon text-white-60">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </button>
                                                    </form>
                                                    <form class="mx-1" action="functions/function.php" method="POST">
                                                        <input type="hidden" name="domain_id"
                                                            value="<?php echo htmlspecialchars($domain['id'] ?? ''); ?>">
                                                        <button type="submit" name="domainDelete"
                                                            class="btn btn-danger btn-sm btn-icon-split">
                                                            <span class="icon text-white-60">
                                                                <i class="fas fa-trash"></i>
                                                            </span>
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php } else { ?>
                                <div class="alert alert-success text-center ">
                                    <strong>60 günden az olan domain yok.</strong>
                                </div>
                                <div class="card-container">
                                    <div class="card">
                                        <h5>Domain & Hosting Ekle</h5>
                                        <p>Yeni bir domain ekleyin.</p>
                                        <a href="add_website.php" class="btn btn-primary">Ekle</a>
                                    </div>
                                    <div class="card">
                                        <h5>Domain & Hosting Yenile</h5>
                                        <p>Domain & Hosting yenileyin.</p>
                                        <a href="list_websites.php" class="btn btn-info">Yenile</a>
                                    </div>
                                    <div class="card">
                                        <h5>Müşteri Yönetimi</h5>
                                        <p>Müşteri bilgilerinizi yönetin.</p>
                                        <a href="list_customers.php" class="btn btn-success">Yönet</a>
                                    </div>
                                </div>
                                <?php } ?>
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