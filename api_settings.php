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
        $pleskQuery = $db->query("SELECT * FROM `plesk`");
        $pleskData = $pleskQuery->fetch(PDO::FETCH_ASSOC);
        $cpanelQuery = $db->query("SELECT * FROM `cpanel`");
        $cpanelData = $cpanelQuery->fetch(PDO::FETCH_ASSOC);
        function connectToCpanelAPI($host, $username, $password) {
            $cpanel = new (array(
                'host'        => $host,
                'username'    => $username,
                'auth_type'   => 'password',
                'password'    => $password,
                'ssl'         => true
            ));
            return $cpanel;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['plesk_host'])) {
                $host = $_POST['plesk_host'];
                $port = $_POST['plesk_port'];
                $protocol = $_POST['plesk_protocol'];
                $username = $_POST['plesk_username'];
                $password = $_POST['plesk_password'];

                $updateQuery = $db->prepare("UPDATE `plesk` SET host = :host, port = :port, protocol = :protocol, username = :username, password = :password WHERE id = :id");
                $updateQuery->bindParam(':host', $host);
                $updateQuery->bindParam(':port', $port);
                $updateQuery->bindParam(':protocol', $protocol);
                $updateQuery->bindParam(':username', $username);
                $updateQuery->bindParam(':password', $password);
                $updateQuery->bindParam(':id', $pleskData['id']);

                if ($updateQuery->execute()) {
                    echo "<p>Plesk ayarları başarıyla güncellendi.</p>";
                } else {
                    echo "<p>Plesk ayarları güncellenirken bir hata oluştu.</p>";
                }
            } elseif (isset($_POST['cpanel_host'])) {
                $host = $_POST['cpanel_host'];
                $username = $_POST['cpanel_username'];
                $password = $_POST['cpanel_password'];
                $updateQuery = $db->prepare("UPDATE `cpanel` SET host = :host, username = :username, password = :password WHERE id = :id");
                $updateQuery->bindParam(':host', $host);
                $updateQuery->bindParam(':username', $username);
                $updateQuery->bindParam(':password', $password);
                $updateQuery->bindParam(':id', $cpanelData['id']);

                if ($updateQuery->execute()) {
                    echo "<p>cPanel ayarları başarıyla güncellendi.</p>";
                } else {
                    echo "<p>cPanel ayarları güncellenirken bir hata oluştu.</p>";
                }
            } elseif (isset($_POST['action'])) {
                $cpanel = connectToCpanelAPI($cpanelData['host'], $cpanelData['username'], $cpanelData['password']);

                switch ($_POST['action']) {
                    case 'create_account':
                        $result = $cpanel->uapi->Account->create_user([
                            'username' => $_POST['new_username'],
                            'password' => $_POST['new_password']
                        ]);
                        echo $result->status ? "Hesap oluşturuldu" : "Hata: " . $result->errors[0];
                        break;

                    case 'create_database':
                        $result = $cpanel->uapi->Mysql->create_database([
                            'name' => $_POST['db_name']
                        ]);
                        echo $result->status ? "Veritabanı oluşturuldu" : "Hata: " . $result->errors[0];
                        break;
                }
            }
        }
        ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="card-body" style="width: 100%">
                            <div class="table-responsive">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="plesk-tab" data-toggle="tab" href="#plesk"
                                            role="tab" aria-controls="plesk" aria-selected="true">Plesk</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="cpanel-tab" data-toggle="tab" href="#cpanel" role="tab"
                                            aria-controls="cpanel" aria-selected="false">cPanel</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="plesk" role="tabpanel"
                                        aria-labelledby="plesk-tab">
                                        <h3>Plesk API Ayarları</h3>
                                        <form action="" method="post">
                                            <div class="form-group">
                                                <label for="plesk_host">Host</label>
                                                <input type="text" class="form-control" id="plesk_host"
                                                    name="plesk_host" required
                                                    value="<?php echo $pleskData['host'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="plesk_port">Port</label>
                                                <input type="text" class="form-control" id="plesk_port"
                                                    name="plesk_port" required
                                                    value="<?php echo $pleskData['port'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="plesk_protocol">Protokol</label>
                                                <input type="text" class="form-control" id="plesk_protocol"
                                                    name="plesk_protocol" required
                                                    value="<?php echo $pleskData['protocol'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="plesk_username">Kullanıcı Adı</label>
                                                <input type="text" class="form-control" id="plesk_username"
                                                    name="plesk_username" required
                                                    value="<?php echo $pleskData['username'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="plesk_password">Şifre</label>
                                                <input type="password" class="form-control" id="plesk_password"
                                                    name="plesk_password" required
                                                    value="<?php echo $pleskData['password'] ?? ''; ?>">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Kaydet</button>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="cpanel" role="tabpanel" aria-labelledby="cpanel-tab">
                                        <h3>cPanel API Ayarları</h3>
                                        <form action="" method="post">
                                            <div class="form-group">
                                                <label for="cpanel_host">Host</label>
                                                <input type="text" class="form-control" id="cpanel_host"
                                                    name="cpanel_host" required
                                                    value="<?php echo $cpanelData['host'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="cpanel_username">Kullanıcı Adı</label>
                                                <input type="text" class="form-control" id="cpanel_username"
                                                    name="cpanel_username" required
                                                    value="<?php echo $cpanelData['username'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="cpanel_password">Şifre</label>
                                                <input type="password" class="form-control" id="cpanel_password"
                                                    name="cpanel_password" required
                                                    value="<?php echo $cpanelData['password'] ?? ''; ?>">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Kaydet</button>
                                        </form>
                                        <hr>
                                        <h3>cPanel İşlemleri</h3>
                                        <form action="" method="post">
                                            <h4>Yeni Hesap Oluştur</h4>
                                            <input type="hidden" name="action" value="create_account">
                                            <div class="form-group">
                                                <label for="new_username">Kullanıcı Adı</label>
                                                <input type="text" class="form-control" id="new_username"
                                                    name="new_username" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="new_password">Şifre</label>
                                                <input type="password" class="form-control" id="new_password"
                                                    name="new_password" required>
                                            </div>
                                            <button type="submit" class="btn btn-success">Hesap Oluştur</button>
                                        </form>
                                        <hr>
                                        <form action="" method="post">
                                            <h4>Yeni Veritabanı Oluştur</h4>
                                            <input type="hidden" name="action" value="create_database">
                                            <div class="form-group">
                                                <label for="db_name">Veritabanı Adı</label>
                                                <input type="text" class="form-control" id="db_name" name="db_name"
                                                    required>
                                            </div>
                                            <button type="submit" class="btn btn-success">Veritabanı Oluştur</button>
                                        </form>
                                    </div>
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