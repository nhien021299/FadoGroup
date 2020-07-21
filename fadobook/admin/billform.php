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
  if (isset($_REQUEST['id']) && $_REQUEST['id'] == "") {
    header("Location: bill.php");
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

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- DataTales Example -->
          <?php 
          if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
            $sql = "SELECT * FROM bill WHERE ID='" . $id . "'";
            $result = DataProvider::executeQuery($sql);
            $row = mysqli_fetch_array($result);
            $user = $row['User'];
            $name = $row['Name'];
            $quantity = $row['Quantity'];
            $total = $row['Total'];
            $phone = $row['Phone'];
            $address = $row['Address'];
            $time = $row['Time'];
            $note = $row['Note'];
            $status = $row['Status'];
          }
          function makeStatusOptionSelected($string, $value, $statusOfThisBill)
          {
            if ($value == $statusOfThisBill) {
              echo "<option value='" . $value . "' selected>". $string ."</option>";
            } else {
              echo "<option value='" . $value . "'>". $string ."</option>";
            }
          }
          ?>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h4 class="m-0 font-weight-bold text-primary d-inline">Chi tiết đơn hàng <?php echo $id ?> </h4>
            </div>
            <div class="card-body">
              <input type="hidden" id="id" value="<?php echo $id ?>"></input>
              <div class="form-row">
                <div class="form-group col-md-8">
                  <strong for="user">Người dùng:</strong>
                  <p type="text" id="user" class="d-inline"><?php echo $user?></p>
                </div>
                <div class="form-group col-md-4">
                  <strong for="time">Thời gian:</strong>
                  <p type="text" id="time" class="d-inline">
                    <?php 
                      $date=date_create($row['Time']);
                      echo date_format($date,"d/m/Y");
                    ?>
                  </p>
                </div>
                <div class="form-group col-md-4">
                  <strong for="name">Họ và tên:</strong>
                  <p type="text" id="name" class="d-inline"><?php echo $name?></p>
                </div>
                <div class="form-group col-md-4">
                  <strong for="phone">Số điện thoại:</strong>
                  <p type="text" id="phone" class="d-inline"><?php echo $phone?></p>
                </div>
                <div class="form-group col-md-4">
                  <strong for="address">Địa chỉ:</strong>
                  <p type="text" id="address" class="d-inline"><?php echo $address?></p>
                </div>
                <div class="form-group col-md-4">
                  <strong for="quantity">Số lượng:</strong>
                  <p type="text" id="quantity" class="d-inline"><?php echo $quantity?></p>
                </div>
                <div class="form-group col-md-4">
                  <strong for="total">Tổng tiền:</strong>
                  <p type="text" id="total" class="d-inline"><?php echo number_format($total,0,".",".")?>₫</p>
                </div>
                <div class="form-group col-md-4">
                  <strong for="note">Trạng thái:</strong>
                  <?php
                    switch($status){
                      case 1: case 2: {
                  ?>
                        <select id="status" class="form-control d-inline w-50" onchange="editStatus()">
                          <option value="1" <?php echo ($status == 1 ? "selected":"")?> >Chờ xử lý</option>
                          <option value="2" <?php echo ($status == 2 ? "selected":"")?> >Đã xử lý</option>
                          <option value="3" >Đã hủy</option>
                        </select>
                  <?php      
                      } break;
                      case 3: {
                  ?>
                        <p type="text" id="total" class="d-inline">Đã hủy</p>
                  <?php     
                      } break;
                    }
                  ?>
                  
                </div>
                <div class="form-group col-md-12">
                  <strong for="note">Ghi chú:</strong>
                  <p type="text" id="note" class="d-inline"><?php echo $note?></p>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0" style="text-align:center">
                  <thead>
                    <tr>
                        <th>Hình</th>
                        <th>Tên</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Tổng tiền</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $sql = "SELECT DISTINCT p.*, bd.Quantity as 'bdQuantity' FROM product as p JOIN billdetail as bd on p.ID = bd.ProductID WHERE p.ID IN (SELECT ProductID FROM billdetail WHERE BillID = '".$id."') AND bd.BillID = '".$id."'";
                      $result = DataProvider::executeQuery($sql);
                      while ($row = mysqli_fetch_array($result)) 
                      {
                    ?>
                    <tr>
                      <td><img src="../img/sanpham/<?php echo $row['Pic'] ?>" style="width:60px; height:60px"></td>
                      <td><?php echo $row['Name'] ?></td>
                      <td><?php echo $row['bdQuantity'] ?></td>
                      <td><?php echo number_format($row['Price'],0,".",".")?>₫</td>
                      <td><?php echo number_format($row['Price']*$row['bdQuantity'],0,".",".")?>₫</td>
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
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

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
  <script src="../js/custom/JS-admin-bill-form.js"></script>
  
</body>

</html>