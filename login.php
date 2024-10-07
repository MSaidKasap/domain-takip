<!DOCTYPE html>
<html lang="tr">
<head>
  <?php require_once 'components/header.php';
  session_start();if (isset($_SESSION['user_id'])) {
    // Dashboard sayfasına yönlendir
    header("Location: /index.php");
    exit();
} 
  ?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="index.php" class="h1"><b>Domain Takip</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Oturumunuzu başlatmak için giriş yapın</p>

      <form action="functions/login.php" method="post">
    <div class="input-group mb-3">
        <input type="email" name="user_mail" class="form-control" placeholder="Email">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
    </div>
    <div class="input-group mb-3">
        <input type="password" name="user_password" class="form-control" placeholder="Password">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>
    <div class="row">
    <?php if (isset($_GET['status']) && $_GET['status'] === 'no'): ?>
        <div class="alert alert-danger" role="alert">
          Bilgiler hatalı, lütfen tekrar deneyin.
        </div>
      <?php endif; ?>
     
        <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Giriş</button>
        </div>
    </div>
    <div class="float-right d-none d-sm-inline">
      Company: <a href="www.dilarabilgisayar.com">Dilara Bilgisayar</a> Tüm hakları saklıdır.
    </div>
    <!-- Default to the left -->

    <strong>&copy;Design By <a href="www.webyerim.com"> M.S.K </a>.  2024 </strong> 
</form>

  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
