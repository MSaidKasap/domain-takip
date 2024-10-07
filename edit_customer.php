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
        if (isset($_GET['customer_id'])) {
            $customer_id = filter_input(INPUT_GET, 'customer_id', FILTER_SANITIZE_NUMBER_INT);
            $stmt = $db->prepare("SELECT * FROM costumer WHERE customer_id = :customer_id AND is_delete = 0");
            $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
            $stmt->execute();
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$customer) {
                echo "Müşteri bulunamadı.";
                exit;
            }
        } else {
            echo "Geçersiz müşteri ID.";
            exit;
        }
        ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="card-body" style="width: 100%">
                            <div class="table-responsive">
                                <div class="container">
                                    <h2>Müşteri Bilgilerini Düzenle</h2>
                                    <form action="functions/function.php" method="post">
                                        <input type="hidden" name="customer_id"
                                            value="<?php echo htmlspecialchars($customer['customer_id']); ?>">
                                        <div class="form-group">
                                            <label>Müşteri Adı:</label>
                                            <input type="text" name="customer_name" class="form-control"
                                                value="<?php echo htmlspecialchars($customer['customer_name']); ?>"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label>Müşteri Telefon:</label>
                                            <input type="text" name="customer_phone" class="form-control"
                                                value="<?php echo htmlspecialchars($customer['customer_phone']); ?>"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label>Müşteri Mail:</label>
                                            <input type="email" name="customer_mail" class="form-control"
                                                value="<?php echo htmlspecialchars($customer['customer_mail']); ?>"
                                                required>
                                        </div>
                                        <button type="submit" name="updateCustomer" id="updateCustomer"
                                            class="btn btn-success">Güncelle</button>
                                        <a href="list_customers.php" class="btn btn-secondary">İptal</a>
                                    </form>
                                </div>
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