<?php
    session_start();
    if(!isset($_SESSION['isLogin'])){
      header("Location: login.php");
		  exit;
    } else {
      $role ="";
      foreach ($_SESSION["isLogin"] as $k => $v) {
        $role = $_SESSION['isLogin'][$k]["Role"];
      }
    }
    if($role != "Admin"){
      header("Location: index.php");
      exit;
    }
    require_once '../php/DataProvider.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>FadoBook.vn - Dashboard</title>
  <!-- Favicon Icon Css -->
  <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon.png">
  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">
  <!-- Custom styles for this page -->
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php include './interface/sidebar.php' ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <?php include './interface/topbar.php' ?>

        <!--Star main -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary d-inline">Banner</h4>
            <a href="bannerform.php" class="btn btn-success float-right">Thêm</a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="text-align:center">
                <thead>
                  <tr>
                    <th style="width:50%">Hình</th>
                    <th>Liên kết</th>
                    <th>Vị trí</th>
                    <th style="width:100px">Thao tác</th>
                  </tr>
                </thead>
                <tbody id="tbody-sanpham">
                  <?php
                  require_once '../php/DataProvider.php';
                  $sql = "SELECT * FROM banner ORDER BY ID ASC";
                  $result = DataProvider::executeQuery($sql);
                  while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>" .
                      "<td> <img src='../img/banner/" . $row['Image'] . "' style=' width:80%; height: 200px;'></td>" .
                      "<td>" . $row['Link'] . "</td>" .
                      "<td>" . $row['Position'] . "</td>" .
                      "<td>".
                        "<a href='bannerform.php?id=" . $row['ID'] . "'>Sửa thông tin</a>".
                      "</td>".
                      "</tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
      <!--End main -->

      <!-- Footer -->
      <?php include './interface/footer.php' ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../js/demo/datatables-demo.js"></script>
  <script src="../js/custom/JS-admin-login.js"></script>
</body>

</html>