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
        if (isset($_GET['user_id'])) {
            $user_id = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);
            $stmt = $db->prepare("SELECT * FROM users WHERE id = :user_id AND is_delete = 0");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$customer) {
                echo "User bulunamadı.";
                exit;
            }
        } else {
            echo "Geçersiz User ID.";
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
                                    <h2>User Bilgilerini Düzenle</h2>
                                    <form action="functions/function.php" method="post">
                                        <input type="hidden" name="user_id"
                                            value="<?php echo htmlspecialchars($customer['id']); ?>">
                                        <div class="form-group">
                                            <label>User Adı:</label>
                                            <input type="text" name="user_name" class="form-control"
                                                value="<?php echo htmlspecialchars($customer['user_name']); ?>"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label>User Telefon:</label>
                                            <input type="text" name="user_phone" class="form-control"
                                                value="<?php echo htmlspecialchars($customer['user_phone']); ?>"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label>User Mail:</label>
                                            <input type="email" name="user_mail" class="form-control"
                                                value="<?php echo htmlspecialchars($customer['user_mail']); ?>"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label>User Password:</label>
                                            <input type="password" name="user_password" class="form-control" required
                                                placeholder="Yeni Şifre Girin">
                                        </div>
                                        <button type="submit" name="updateUsers" id="updateUsers"
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