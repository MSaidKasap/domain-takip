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
                                <?php
                                require_once 'functions/connection.php';
                                require 'functions/PHPMailer/src/PHPMailer.php';
                                require 'functions/PHPMailer/src/SMTP.php';
                                require 'functions/PHPMailer/src/Exception.php';

                                use PHPMailer\PHPMailer\PHPMailer;
                                use PHPMailer\PHPMailer\Exception;

                   

                                $settingsQuery = $db->prepare("SELECT * FROM settings WHERE id = 1");
                                $settingsQuery->execute();
                                $settingsData = $settingsQuery->fetch(PDO::FETCH_ASSOC);

                                $mailResult = ''; 
                                if (isset($_POST['testMail'])) {
                                    $testMailAddress = $_POST['test_mail_address'];
                                    $mailAdress = $settingsData['mail_adress'];
                                    $mailPassword = $settingsData['mail_password'];
                                    $hostAdress = $settingsData['host_adress'];
                                    $portNumber = $settingsData['port_number'];
                                    $siteTitle = $settingsData['title']; 

                                    $mail = new PHPMailer(true);
                                    try {
                                        $mail->isSMTP();
                                        $mail->Host = $hostAdress;
                                        $mail->SMTPAuth = true;
                                        $mail->Username = $mailAdress;
                                        $mail->Password = $mailPassword;
                                        $mail->SMTPOptions = array(
                                            'ssl' => array(
                                                'verify_peer' => false,
                                                'verify_peer_name' => false,
                                                'allow_self_signed' => true
                                            )
                                        );
                                        $mail->Port = $portNumber;
                                        $mail->setFrom($mailAdress, $siteTitle); // Site adını title olarak ayarlayın
                                        $mail->addAddress($testMailAddress);
                                        $mail->isHTML(true);
                                        $mail->CharSet = 'UTF-8'; 
                                        $mail->Subject = 'Test Mail';
                                        $mail->Body = 'Bu bir test mailidir. Eğer bu maili aldıysanız, ayarlarınız doğru çalışıyor demektir!';
                                        if ($mail->send()) {
                                            $mailResult = '<div class="alert alert-success">Test mail başarıyla gönderildi.</div>';
                                        } else {
                                            $mailResult = '<div class="alert alert-danger">Mail gönderme başarısız oldu.</div>';
                                        }
                                    } catch (Exception $e) {
                                        $mailResult = '<div class="alert alert-danger">Mail gönderme başarısız oldu: ' . $mail->ErrorInfo . '</div>';
                                    }
                                }
                                ?>
                                <form action="" method="POST" data-parsley-validate>
                                    <div class="form-group">
                                        <label for="test_mail_address">Test Mail Adresi:</label>
                                        <input type="email" class="form-control" name="test_mail_address" placeholder="Test mail adresinizi girin" required>
                                    </div>
                                    <button type="submit" name="testMail" class="btn btn-primary">Test Mail Gönder</button>
                                </form>
                                <?php
                                if (!empty($mailResult)) {
                                    echo $mailResult;
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