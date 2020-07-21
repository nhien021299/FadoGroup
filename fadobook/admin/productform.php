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
    header("Location: product.php");
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
            $sql = "SELECT * FROM product WHERE ID='" . $id . "'";
            $result = DataProvider::executeQuery($sql);
            $row = mysqli_fetch_array($result);
            $name = $row['Name'];
            $description = $row['Description'];
            $category = $row['Category'];
            $type = $row['Type'];
            $time = $row['Time'];
            $price = $row['Price'];
            $quantity = $row['Quantity'];
            $pic = $row['Pic'];
            $status = $row['Status'];
            $author = $row['Author'];
          }
          function makeTypeOptionSelected($row, $typeOfThisProduct)
          {
            if ($row["TypeID"] == $typeOfThisProduct) {
              echo "<option value='" . $row["TypeID"] . "' selected>" . $row["TypeName"] . "</option>";
            } else {
              echo "<option value='" . $row["TypeID"] . "'>" . $row["TypeName"] . "</option>";
            }
          }
          function makeStatusOptionSelected($status, $statusOfThisProduct)
          {
            if ($status == $statusOfThisProduct) {
              echo "<option value='" . $status . "' selected>" . (($status == 0) ? "Hoạt động" : "Không hoạt động") . "</option>";
            } else {
              echo "<option value='" . $status . "'>" . (($status == 0) ? "Hoạt động" : "Không hoạt động") . "</option>";
            }
          }
          function makeCategoryOptionSelected($category, $categoryOfThisProduct)
          {
            if ($category['Category'] == $categoryOfThisProduct) {
              echo "<option value='" . $category['Category'] . "' selected>" . $category['Category_name'] . "</option>";
            } else {
              echo "<option value='" . $category['Category'] . "'>" . $category['Category_name'] . "</option>";
            }
          }
          ?>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h4 class="m-0 font-weight-bold text-primary d-inline"><?php echo (isset($_REQUEST['id']) ? "Sửa sản phẩm " . $id : "Thêm sản phẩm") ?></h4>
            </div>
            <form class="card-body" id="product-form">
              <input type="hidden" id="id" value="<?php echo (isset($_REQUEST['id']) ? $id : "") ?>"></input>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="name">Tên sách:</label>
                  <input type="text" id="name" class="form-control" placeholder="Tên sách" value="<?php echo (isset($_REQUEST['id']) ? $name : "") ?>"></input>
                </div>
                <div class="form-group col-md-3">
                  <label for="author">Tác giả:</label>
                  <input type="text" id="author" class="form-control" placeholder="Tác giả" value="<?php echo (isset($_REQUEST['id']) ? $author: "") ?>"></input>
                </div>
                <div class="form-group col-md-3">
                  <label for="quantity">Số lượng:</label>
                  <input type="text" id="quantity" class="form-control" placeholder="Số lượng" value="<?php echo (isset($_REQUEST['id']) ? $quantity : "") ?>" <?php echo (isset($_REQUEST['id']) && $quantity >= 300 ? "disabled": "") ?>></input>
                </div>
                <div class="form-group col-md-3">
                  <label for="time">Ngày xuất bản:</label>
                  <input type="date" id="time" class="form-control" placeholder="Ngày xuất bản" value="<?php echo (isset($_REQUEST['id']) ? $time : "") ?>"></input>
                </div>
                <div class="form-group col-md-4">
                  <label for="price">Giá tiền:</label>
                  <input type="text" id="price" class="form-control" placeholder="Giá sản phẩm" value="<?php echo (isset($_REQUEST['id']) ? $price : "") ?>"></input>
                </div>
                <div class="form-group col-md-4">
                  <label for="type">Loại sản phẩm:</label>
                  <select id="type" class="form-control">
                    <?php
                    $sql = "SELECT * FROM type";
                    $result = DataProvider::executeQuery($sql);
                    while($row = mysqli_fetch_array($result)){
                      if(isset($_REQUEST['id'])) {
                        makeTypeOptionSelected($row, $type);
                      } else {
                        makeTypeOptionSelected($row,"");
                      }
                    };
                    ?>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="category">Thể loại:</label>
                  <select id="category" class="form-control">
                    <?php
                    $sql = "SELECT * FROM category";
                    $result = DataProvider::executeQuery($sql);
                    while($row = mysqli_fetch_array($result)){
                      if(isset($_REQUEST['id'])) {
                        makeCategoryOptionSelected($row, $category);
                      } else {
                        makeCategoryOptionSelected($row,"");
                      }
                    } 
                    ?>
                  </select>
                </div>
                
                <div class="form-group col-md-12">
                  <label for="description">Mô tả:</label>
                  <textarea rows="3" id="description" class="form-control" placeholder="Mô tả sản phẩm"><?php echo (isset($_REQUEST['id']) ? $description : "") ?></textarea>
                </div>
                <div class="form-group col-md-6">
                  <label for="status">Trạng thái:</label>
                  <select id="status" class="form-control">
                  <?php
                    if(isset($_REQUEST['id'])){
                      makeStatusOptionSelected(0, $status);
                      makeStatusOptionSelected(1, $status);
                    } else {
                  ?>
                    <option value='0'>Hoạt động</option>
                    <option value='1'>Không hoạt động</option>
                  <?php  
                    }
                  ?>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="image">Ảnh đại diện:</label>
                  <input type="file" id="image" class="form-control"></input>
                </div>
                <div class="form-group col-md-12">
                  <input type="button" value="Xác nhận" style="float:right" class="btn bg-success text-white" onclick="<?php echo (isset($_REQUEST['id']) ? "editProduct()" : "addProduct()") ?>"></input>
                  <a type="button" href="product.php" style="float:right" role="button" class="btn bg-danger text-white mr-sm-2">Hủy</a>
                  <?php
                    if (isset($_REQUEST['id'])) {
                      echo "<input type=\"button\" value=\"Xóa sản phẩm\" class=\"btn bg-danger text-white\" onclick=\"deleteProduct(".$id.")\"></input>";
                    }
                  ?>
                </div>
              </div>
            </form>
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

  <script src="../js/custom/JS-admin-product-form.js"></script>
  <script src="../js/custom/JS-admin-login.js"></script>
</body>

</html>