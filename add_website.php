<!DOCTYPE html>
<html lang="tr">

<head>
    <?php require_once 'components/header.php'; ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php
        require_once 'components/sidebar.php';
        require_once 'functions/connection.php';
        ?>
        <style>
            body {
                overflow-x: hidden;
            }

            .content-wrapper {
                max-width: 100%;
                margin: 0 auto;
            }

            .form-row {
                width: 100%;
                display: flex;
                flex-wrap: wrap;
            }

            .form-group {
                flex: 1 1 30%;
                padding: 10px;
            }

            .table-responsive {
                overflow-x: auto;
            }
        </style>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2 col-md-12">
                        <div class="card-body" style="width: 100%">
                            <div class="table-responsive">
                                <form action="functions/function.php" method="POST" enctype="multipart/form-data">
                                    <!-- Domain Kayıt Alanları -->
                                    <h6 class="m-0 font-weight-bold text-secondary text-center">Domain Bilgileri</h6>
                                    <div class="form-row justify-content-center">
                                        <div class="form-group col-md-3">
                                            <label>Müşteri</label>
                                            <select id="customer_list" class="form-control" name="domain_customer"
                                                onchange="customerSecme();">
                                                <!-- Müşteri Seçenekleri -->
                                                <?php
                                                $customer = $db->prepare("SELECT * FROM costumer");
                                                $customer->execute();
                                                while ($customerpull = $customer->fetch(PDO::FETCH_ASSOC)) { ?>
                                                    <option value="<?php echo $customerpull['customer_id']; ?>">
                                                        <?php echo $customerpull['customer_name']; ?></option>
                                                <?php }
                                                if ($customer->rowCount() == 0) { ?>
                                                    <option></option>
                                                <?php }
                                                ?>
                                                <option value="customer_add">Müşteri Ekle</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Domain Adı</label>
                                            <input type="text" class="form-control" name="domain_name"
                                                placeholder="Domain Adı">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Domain Kayıtlı Şirket</label>
                                            <select id="company_list" class="form-control" name="company_domain"
                                                onchange="companySecme('domain');">
                                                <?php
                                                $company = $db->prepare("SELECT * FROM registrars");
                                                $company->execute();
                                                while ($companypull = $company->fetch(PDO::FETCH_ASSOC)) { ?>
                                                    <option value="<?php echo $companypull['company_name']; ?>">
                                                        <?php echo $companypull['company_name']; ?></option>
                                                <?php }
                                                if ($company->rowCount() == 0) { ?>
                                                    <option></option>
                                                <?php }
                                                ?>
                                                <option value="company_add">Şirket Ekle</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row justify-content-center">
                                        <div class="form-group col-md-3">
                                            <label>Domain Başlangıç</label>
                                            <input type="date" class="form-control" name="domain_start">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Domain Bitiş</label>
                                            <input type="date" class="form-control" name="domain_end">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Domain Fiyat</label>
                                            <input type="text" class="form-control" name="domain_price"
                                                placeholder="Domain Fiyatı">
                                        </div>
                                    </div>
                                    <hr>
                                    <h6 class="m-0 font-weight-bold text-secondary text-center">Hosting Bilgileri</h6>
                                    <div class="form-row justify-content-center">
                                        <div class="form-group col-md-3">
                                            <label>Hosting Kayıtlı Şirket</label>
                                            <select id="hosting_companylistesi" class="form-control"
                                                name="hosting_company" onchange="companySecme('hosting');">
                                                <?php
                                                $company = $db->prepare("SELECT * FROM registrars");
                                                $company->execute();
                                                while ($companypull = $company->fetch(PDO::FETCH_ASSOC)) { ?>
                                                    <option value="<?php echo $companypull['company_name']; ?>">
                                                        <?php echo $companypull['company_name']; ?></option>
                                                <?php }
                                                if ($company->rowCount() == 0) { ?>
                                                    <option></option>
                                                <?php }
                                                ?>
                                                <option value="company_add">Şirket Ekle</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Hosting Başlangıç</label>
                                            <input type="date" class="form-control" name="hosting_start">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Hosting Bitiş</label>
                                            <input type="date" class="form-control" name="hosting_end">
                                        </div>
                                    </div>

                                    <div class="form-row justify-content-center">
                                        <div class="form-group col-md-3">
                                            <label>Otomatik E-posta Gönder</label>
                                            <select class="form-control" name="automatic_mail">
                                                <option value="1">Evet</option>
                                                <option value="0">Hayır</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Otomatik Mesaj Gönder</label>
                                            <select class="form-control" name="automatic_sms">
                                                <option value="1">Evet</option>
                                                <option value="0">Hayır</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Hosting Fiyat</label>
                                            <input type="text" class="form-control" name="hosting_price"
                                                placeholder="Hosting Fiyatı">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <button type="submit" name="domainAdd" class="btn btn-primary">Kaydet</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        require_once 'components/csbar.php'
        ?>
        <?php
        require_once 'components/footer.php';
        require_once 'components/js.php'
        ?>
    </div>
</body>
<script type="text/javascript">
    function companySecme(type) {
        var companylistesiId = type === 'domain' ? 'company_list' : 'hosting_companylistesi';
        var selectedValue = document.getElementById(companylistesiId).value;

        if (selectedValue === 'company_add') {
            window.open('companylar.php', '_blank');
        }
    }

    function customerSecme() {
        var customer_list = document.getElementById('customer_list');
        var selectedValue = customer_list.value;

        if (selectedValue === 'customer_add') {
            window.open('customerler.php', '_blank');
        }
    }
</script>

</html>