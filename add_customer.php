<!DOCTYPE html>
<html lang="tr">

<head>
    <?php require_once 'components/header.php'; ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php
        require_once 'components/sidebar.php';
        ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-12">
                        <div class="card-body" style="width: 100%">
                            <div class="container">
                                <h2>Müşteri Ekle</h2>
                                <form action="functions/function.php" method="post">
                                    <div class="form-group mb-">
                                        <label>Müşteri Adı:</label>
                                        <input type="text" name="customer_name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Müşteri Telefon:</label>
                                        <input type="text" name="customer_phone" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Müşteri Mail:</label>
                                        <input type="email" name="customer_mail" class="form-control" required>
                                    </div>
                                    <button type="submit" name="addCustomer" class="btn btn-success">Ekle</button>
                                    <a href="list_customers.php" class="btn btn-secondary">İptal</a>
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