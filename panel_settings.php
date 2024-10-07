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
    $smsQuery = $db->prepare("SELECT * FROM sms_api_credentials WHERE id = 1");
    $smsQuery->execute();
    $smsData = $smsQuery->fetch(PDO::FETCH_ASSOC);
    $settingsQuery = $db->prepare("SELECT * FROM settings WHERE id = 1");
    $settingsQuery->execute();
    $settingsData = $settingsQuery->fetch(PDO::FETCH_ASSOC);
    if (isset($_POST['testMail'])) {
      $testMailAddress = $_POST['test_mail_address'];
      $mailAdress = $settingsData['mail_adress'];
      $mailPassword = $settingsData['mail_password'];
      $hostAdress = $settingsData['host_adress'];
      $portNumber = $settingsData['port_number'];
      require 'path/to/PHPMailer/PHPMailerAutoload.php'; 
      $mail = new PHPMailer\PHPMailer\PHPMailer();
      $mail->isSMTP();
      $mail->Host = $hostAdress; 
      $mail->SMTPAuth = true;
      $mail->Username = $mailAdress; 
      $mail->Password = $mailPassword; 
      $mail->SMTPSecure = 'tls'; 
      $mail->Port = $portNumber; 
      $mail->setFrom($mailAdress, 'Site Adı'); 
      $mail->addAddress($testMailAddress);
      $mail->isHTML(true);
      $mail->Subject = 'Test Mail';
      $mail->Body    = 'Bu bir test mailidir. Eğer bu maili aldıysanız, ayarlarınız doğru çalışıyor demektir!';

      if ($mail->send()) {
          header("Location: yourpage.php?durum=ok"); 
      } else {
          header("Location: yourpage.php?durum=no"); 
      }
      exit; 
  }
    ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="card-body" style="width: 100%">
                            <div class="table-responsive">
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="site-tab" data-toggle="tab" href="#site"
                                                role="tab" aria-controls="site" aria-selected="true">
                                                <i class="fas fa-cogs"></i> Site Ayarları
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="mail-tab" data-toggle="tab" href="#mail" role="tab"
                                                aria-controls="mail" aria-selected="false">
                                                <i class="fas fa-envelope"></i> Mail Ayarları
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="sms-tab" data-toggle="tab" href="#sms" role="tab"
                                                aria-controls="sms" aria-selected="false">
                                                <i class="fas fa-sms"></i> SMS Ayarları
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content pt-2" id="myTabContent">
                                        <div class="tab-pane fade show active form-container" id="site" role="tabpanel"
                                            aria-labelledby="site-tab">
                                            <form action="functions/function.php" method="POST"
                                                enctype="multipart/form-data" data-parsley-validate>
                                                <div class="form-row mb-12 pt-2">
                                                    <div class="file-loading pt-2">
                                                        <label>Site Logo</label>
                                                        <input class="form-control" id="sitelogosu" name="site_logo"
                                                            type="file">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6 pt-2">
                                                        <label>Site Başlığı</label>
                                                        <input type="text" required class="form-control" name="title"
                                                            value="<?php echo $settingsData['title'] ?>"
                                                            placeholder="Site Başlığı">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6 pt-2">
                                                        <label>Site Açıklaması</label>
                                                        <input type="text" required class="form-control"
                                                            name="description"
                                                            value="<?php echo $settingsData['description'] ?>"
                                                            placeholder="Site Açıklaması (En Fazla 250 Karakter)">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6 pt-2">
                                                        <label>Site Sahibi</label>
                                                        <input type="text" required class="form-control" name="owner"
                                                            value="<?php echo $settingsData['owner'] ?>"
                                                            placeholder="Site Sahibi">
                                                    </div>
                                                </div>
                                                <button type="submit" name="generalSettings"
                                                    class="btn btn-primary">Kaydet</button>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade form-container" id="mail" role="tabpanel"
                                            aria-labelledby="mail-tab">
                                            <form action="functions/function.php" method="POST" data-parsley-validate>
                                                <div class="form-row pt-2">
                                                    <div class="form-group col-md-6">
                                                        <label>Mail Adresi</label>
                                                        <input type="mail" required class="form-control"
                                                            placeholder="Mail Adresinizi Girin" name="mail_adress"
                                                            value="<?php echo $settingsData['mail_adress'] ?>">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Mail Şifresi</label>
                                                        <input type="password" class="form-control"
                                                            placeholder="Mail Şifresi" name="mail_password"
                                                            value="<?php echo $settingsData['mail_password'] ?>">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Host Adresi</label>
                                                        <input type="text" required class="form-control"
                                                            placeholder="Host Adresinizi Girin" name="host_adress"
                                                            value="<?php echo $settingsData['host_adress'] ?>">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Port Numarası</label>
                                                        <input type="number" required class="form-control"
                                                            name="port_number"
                                                            value="<?php echo $settingsData['port_number'] ?>">
                                                    </div>
                                                </div>
                                         

                                                <button type="submit" name="mailSettings"
                                                    class="btn btn-primary">Kaydet</button>
                                                    <a href="mail_test.php" class="btn btn-primary">Test</a>

                                            </form>
                                        </div>
                                        <div class="tab-pane fade form-container" id="sms" role="tabpanel"
                                            aria-labelledby="sms-tab">
                                            <form action="functions/function.php" method="POST" data-parsley-validate>
                                                <div class="form-row pt-2">
                                                    <div class="form-group col-md-6">
                                                        <label>SMS Kullanıcı Adı</label>
                                                        <input type="text" class="form-control" name="username"
                                                            placeholder="İletimerkezi Kayıt Numaranız"
                                                            value="<?php echo isset($smsData['username']) ? $smsData['username'] : ''; ?>">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>SMS Şifre</label>
                                                        <input type="text" class="form-control" name="password"
                                                            placeholder="Şifreniz"
                                                            value="<?php echo isset($smsData['password']) ? $smsData['password'] : ''; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>SMS Başlık</label>
                                                        <input type="text" class="form-control" name="header"
                                                            placeholder="Başlık"
                                                            value="<?php echo isset($smsData['header']) ? $smsData['header'] : ''; ?>"
                                                            maxlength="11" oninput="validateLength(this)">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label>Mesaj Şablonu 1</label>
                                                        <textarea class="form-control"
                                                            name="message_template"><?php echo isset($smsData['message_template']) ? $smsData['message_template'] : ''; ?></textarea>
                                                    </div>
                                                </div>

                                                <button type="submit" name="smsApi"
                                                    class="btn btn-primary">Kaydet</button>
                                            </form>

                                        </div>
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
<?php if (@$_GET['durum'] == "no") {
?>

<script>
Swal.fire({
    icon: 'error',
    title: 'İşlem Başarısız',
    text: 'Lütfen Tekrar Deneyin',
    showConfirmButton: true,
    confirmButtonText: 'Kapat'
})
</script>
<?php } ?>

<?php if (@$_GET['durum'] == "ok") { ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'İşlem Başarılı',
    text: 'İşleminiz Başarıyla Gerçekleştirildi',
    showConfirmButton: true,
    confirmButtonText: 'Kapat'
})
</script>
<?php }
?>

</html>