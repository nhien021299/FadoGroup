<?php
session_start();
if (!isset($_SESSION['isLoginUser'])) {
    header("Location: index.php");
    exit;
}
require_once './php/DataProvider.php';
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <script src="https://kit.fontawesome.com/3d02397db2.js" crossorigin="anonymous"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon Icon Css -->
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon.png">
    <!-- Animation CSS -->
    <link rel="stylesheet" href="css/animate.css" type="text/css">
    <!-- Font Css -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="css/font-awesome.css" type="text/css" rel="stylesheet">
    <link href="css/ionicons.min.css" type="text/css" rel="stylesheet">
    <!-- Owl Css -->
    <link href="css/owl.carousel.min.css" type="text/css" rel="stylesheet">
    <link href="css/owl.theme.default.min.css" type="text/css" rel="stylesheet">
    <!-- Magnific Popup Css -->
    <link href="css/magnific-popup.css" type="text/css" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <!-- Price Filter Css -->
    <link href="css/jquery-ui.css" type="text/css" rel="stylesheet">
    <!-- Scrollbar Css -->
    <link href="css/mCustomScrollbar.min.css" type="text/css" rel="stylesheet">
    <!-- Select2 Css -->
    <link href="css/select2.min.css" type="text/css" rel="stylesheet">
    <!-- main css -->
    <link href="css/style.css" type="text/css" rel="stylesheet">

    <link href="css/responsive.css" type="text/css" rel="stylesheet">

    <link href="css/custom/CSS-product.css" type="text/css" rel="stylesheet">
    <title>FadoBook.vn</title>
</head>

<body>
    <!-- LOADER -->
    <div id="preloader">
        <div class="loading_wrap">
            <img src="img/logo1.png" alt="logo">
        </div>
    </div>
    <!-- LOADER -->

    <!-- Start Header Section -->
    <?php
    include './interface/header.php'
    ?>
    <!-- End Header Section -->
    <?php
    $email = "";
    foreach ($_SESSION['isLoginUser'] as $k => $v) {
        $email = $_SESSION['isLoginUser'][$k]['Email'];
    }
    $sql = "SELECT * FROM user where Email ='" . $email . "'";
    $result = DataProvider::executeQuery($sql);
    $row = mysqli_fetch_array($result);
    $name = $row['Name'];
    $phone = $row['Phone'];
    $address = $row['Address'];
    ?>
    <!-- Start Info Section -->
    <section class="user-section">
        <div class="container">
            <div class="row">
                <div class="account-page col-sm-9">
                    <h1 class="title page-title mb-5" style="font-weight: bold;">Thông tin của tôi</h1>
                    <form id="information-form">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="name">Họ và tên:</label>
                                <input type="text" id="name" class="form-control" placeholder="Họ và tên" value="<?php echo $name ?>"></input>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="name">Số điện thoại:</label>
                                <input type="text" id="phone" class="form-control" placeholder="Số điện thoại" value="<?php echo $phone ?>"></input>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="name">Địa chỉ:</label>
                                <input type="text" id="address" class="form-control" placeholder="Địa chỉ" value="<?php echo $address ?>"></input>
                            </div>
                            <a href="user.php" class="form-group col-md-5 btn btn-primary rounded" role="button">Quay lại</a>
                            <button onclick="saveInfo()" type="button" class="form-group col-md-5 btn btn-primary rounded">Xác nhận</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End Info Section -->


    <!-- Start Footer Section -->
    <?php include './interface/footer.php' ?>
    <!-- End Footer Section -->

    <!-- Start Quickview Popup Section -->
    <?php include './interface/quickview.php' ?>
    <!-- End Quickview Popup Section -->

    <!-- Jquery js -->
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <!-- popper.min js -->
    <script src="js/popper.min.js" type="text/javascript"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Magnific Popup js -->
    <script src="js/jquery.magnific-popup.min.js" type="text/javascript"></script>
    <!-- Map js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7TypZFTl4Z3gVtikNOdGSfNTpnmq-ahQ" type="text/javascript"></script>
    <!-- Owl js -->
    <script src="js/owl.carousel.min.js" type="text/javascript"></script>
    <!-- Countdown js -->
    <script src="js/countdown.min.js" type="text/jscript"></script>
    <!-- Counter js -->
    <script src="js/jquery.countup.js" type="text/javascript"></script>
    <!-- waypoint js -->
    <script src="js/waypoint.js" type="text/javascript"></script>
    <!-- Select2 js -->
    <script src="js/select2.min.js" type="text/javascript"></script>
    <!-- Price Slider js -->
    <script src="js/jquery-price-slider.js" type="text/javascript"></script>
    <!-- jquery.elevatezoom js -->
    <script src='js/jquery.elevatezoom.js' type="text/javascript"></script>
    <!-- imagesloaded.pkgd.min js -->
    <script src='js/imagesloaded.pkgd.min.js' type="text/javascript"></script>
    <!-- isotope.min js -->
    <script src='js/isotope.min.js' type="text/javascript"></script>
    <!-- jquery.fitvids js -->
    <script src='js/jquery.fitvids.js' type="text/javascript"></script>
    <!-- mCustomScrollbar.concat.min js -->
    <script src="js/mCustomScrollbar.concat.min.js" type="text/javascript"></script>
    <!-- Custom css -->
    <script src="js/custom.js" type="text/javascript"></script>

    <script src="js/custom/JS-cart.js" type="text/javascript"></script>

    <script src="./js/custom/JS-product.js"></script>
    <script src="./js/custom/JS-user.js"></script>

</body>

</html>