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
    <script src="https://kit.fontawesome.com/3d02397db2.js" crossorigin="anonymous"></script>
    <!-- Required meta tags -->
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

    ?>
    <!-- Start Bill Section -->
    <section class="bill-section" style="height:450px;">
        <div class="container">
            <div class="row">
                <div id="content" class="bill-page col-sm-12">
                    <h1 class="title page-title mb-5" style="font-weight: bold;">Lịch sử đơn hàng</h1>
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0" style="text-align:center">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Thời gian</th>
                                    <th>Số lượng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th style="width:150px">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $email = "";
                                    foreach($_SESSION['isLoginUser'] as $k => $v){
                                        $email =  $_SESSION['isLoginUser'][$k]['Email'];
                                    }

                                    $sql = "SELECT * FROM bill WHERE User='".$email."'";
                                    $result = DataProvider::executeQuery($sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['ID']?></td>
                                    <td>
                                        <?php 
                                            $date=date_create($row['Time']);
                                            echo date_format($date,"d/m/Y");
                                        ?>
                                    </td>
                                    <td><?php echo $row['Quantity']?></td>
                                    <td><?php echo number_format($row['Total'],0,".",".")?>₫</td>
                                    <td><?php echo ($row['Status'] == 1 ? "Chờ xử lý": "Đã xử lý")?></td>
                                    <td>
                                        <a href="#quickviewBill-popup" class="quickviewBill-popup-link" onclick="showDetailBill(<?php echo $row['ID']?>)" >Xem chi tiết</a>
                                    </td>
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
    </section>
    <!-- End Bill Section -->


    <!-- Start Footer Section -->
    <?php include './interface/footer.php' ?>
    <!-- End Footer Section -->

    <!-- Start Quickview Popup Section -->
    <?php include './interface/quickview.php' ?>
    <!-- End Quickview Popup Section -->

    <!-- Start Quickview Bill Popup Section -->
    <?php include './interface/quickviewBill.php' ?>
    <!-- End Quickview Bill Popup Section -->

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

    <script src="./js/custom/JS-user.js"></script>

</body>

</html>