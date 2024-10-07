<!DOCTYPE html>
<html lang="tr">

<head>
    <?php require_once 'components/header.php'; ?>
</head>
<style>
html,
body {
    max-width: 100%;
    overflow-x: hidden;
    /* Yatay taşmayı engelle */
}

.wrapper {
    width: 100%;
    box-sizing: border-box;
    /* Genişliği sayfanın dışına taşırmadan ayarla */
    padding: 0;
    margin: 0;
}

.form-row,
.table-responsive,
.content-wrapper {
    max-width: 100%;
    /* Taşma olmasın diye genişlik kontrolü */
    overflow-x: hidden;
    margin: 0;
    padding: 0 15px;
    /* Kenarlara taşmayı önlemek için biraz boşluk bırak */
}

.card-body {
    width: 100%;
    /* Kartın dışına taşmasını önle */
    padding: 0;
    box-sizing: border-box;
}
</style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php
    require_once 'components/sidebar.php';
    require_once 'functions/connection.php';
    $domain_id = $_POST['domain_id'];

    $domainsql = $db->prepare("SELECT * FROM domains WHERE id = :domain_id");
    $domainsql->bindParam(':domain_id', $_POST['domain_id'], PDO::PARAM_INT);
    $domainsql->execute();
    $domainpull = $domainsql->fetch(PDO::FETCH_ASSOC);
        if (!$domainpull) {
      echo 'Domain not found.';
      exit;
    }
    ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2 pt-4">
                        <div class="card-body" style="width: 100%">
                            <div class="table-responsive">

                                <form action="functions/function.php" method="POST" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col-md-4 col-sm-12 ">


                                            <label>Domain Adı</label>
                                            <input type="text" class="form-control" name="domain_name"
                                                placeholder="Domain Adı"
                                                value="<?php echo htmlspecialchars($domainpull['domain_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Müşteri</label>
                                            <select class="form-control" name="customer_id">
                                                <?php
              $customer = $db->prepare("SELECT * FROM costumer");
              $customer->execute();
              while ($customerpull = $customer->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <option <?php if ($customerpull['customer_id'] == ($domainpull['customer_id'] ?? '')) {
          echo "selected";
        } ?> value="<?php echo htmlspecialchars($customerpull['customer_id'], ENT_QUOTES, 'UTF-8'); ?>">
                                                    <?php echo htmlspecialchars($customerpull['customer_name'], ENT_QUOTES, 'UTF-8'); ?>
                                                </option>

                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Domain Başlangıç</label>
                                            <input type="date" class="form-control" name="domain_start"
                                                placeholder="Domain Başlangıç"
                                                value="<?php echo htmlspecialchars($domainpull['domain_start'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Domain Kayıtlı Firma</label>
                                            <select id="company_domainlistesi" class="form-control"
                                                name="company_domain" onchange="firmaSecme('domain');">
                                                <?php
              $company = $db->prepare("SELECT * FROM registrars");
              $company->execute();
              while ($companypull = $company->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <option
                                                    value="<?php echo htmlspecialchars($companypull['company_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                                    <?php echo htmlspecialchars($companypull['company_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                                </option>
                                                <?php }
              if ($company->rowCount() == 0) { ?>
                                                <option></option>
                                                <?php }
              ?>

                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Fiyat</label>
                                            <input type="text" class="form-control" name="domain_price"
                                                placeholder="Fiyat"
                                                value="<?php echo htmlspecialchars($domainpull['domain_price'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Domain Bitiş</label>
                                            <input type="date" class="form-control" name="domain_end"
                                                placeholder="Domain Bitiş"
                                                value="<?php echo htmlspecialchars($domainpull['domain_end'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                        </div>

                                    </div>
                                    <input type="hidden" name="domain_id"
                                        value="<?php echo htmlspecialchars($_POST['domain_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" name="domainEdit" class="btn btn-primary"
                                        style="float: right;">Kaydet</button>
                                </form>

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