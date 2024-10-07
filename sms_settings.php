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