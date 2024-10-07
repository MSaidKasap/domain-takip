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
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="card-body" style="width: 100%">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="domaintablosu" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Müşteri Adı</th>
                                            <th>Müşteri Telefon</th>
                                            <th>Müşteri Mail</th>
                                            <th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $domainsql = $db->prepare("SELECT * FROM costumer WHERE is_delete=0");
                                        $domainsql->execute();
                                        while ($domainlist = $domainsql->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($domainlist['customer_id'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($domainlist['customer_name'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($domainlist['customer_phone'] ?? ''); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($domainlist['customer_mail'] ?? ''); ?></td>
                                            <td>
                                                <form action="edit_customer.php" method="get" style="display:inline;">
                                                    <input type="hidden" name="customer_id"
                                                        value="<?php echo htmlspecialchars($domainlist['customer_id']); ?>">
                                                    <button type="submit"
                                                        class="btn btn-warning btn-sm">Düzenle</button>
                                                </form>
                                                <form action="functions/function.php" method="post"
                                                    style="display:inline;">
                                                    <input type="hidden" name="customer_id"
                                                        value="<?php echo htmlspecialchars($domainlist['customer_id']); ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        id="deleteCustomer" name="deleteCustomer"
                                                        onclick="return confirm('Bu müşteri kaydını silmek istediğinize emin misiniz?');">Sil</button>
                                                </form>

                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
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