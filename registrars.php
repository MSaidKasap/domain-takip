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
                                            <th>Firma Adı</th>
                                            <th>Müşteri Telefon</th>
                                            <th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $registrarssql = $db->prepare("SELECT * FROM registrars WHERE is_delete=0");
                                        $registrarssql->execute();
                                        while ($registrarslist = $registrarssql->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($registrarslist['id'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($registrarslist['company_name'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($registrarslist['link'] ?? ''); ?>
                                            </td>

                                            <td>
                                         
                                                <form action="functions/function.php" method="post"
                                                    style="display:inline;">
                                                    <input type="hidden" name="registrars_id"
                                                        value="<?php echo htmlspecialchars($registrarslist['id']); ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        id="deleteRegistrar" name="deleteRegistrar"
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