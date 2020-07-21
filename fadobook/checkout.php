<?php
session_start();
if (!isset($_SESSION["cart_item"]) || empty($_SESSION["cart_item"])) {
    header("Location: cart.php");
    exit;
}
?>

<!doctype html>
<html lang="en">

<!-- Mirrored from bestwebcreator.com/ATZShop/demo/product-detail.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 29 Jan 2020 03:54:57 GMT -->

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

    <link href="css/custom/CSS-cart.css" type="text/css" rel="stylesheet">
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

    <!-- Start Cart Detail Section -->
    <section class="cart-detail-section">
        <div class="container" style="min-height: 300px;">
            <div class="row" id="cartDetailContainer">
                <?php if (isset($_SESSION["cart_item"])) {
                    $total_quantity = 0;
                    $total_price = 0;
                ?>

                    <div class="col-md-12" style="background: rgba(240, 242, 245, 1); border: 1px solid #dee2e6">
                        <div class="mb-2 mt-2">
                            <h3>Giỏ hàng</h3>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td class="text-center td-image bg-white ">Hình ảnh</td>
                                    <td class="text-center td-name bg-white ">Tên sản phẩm</td>
                                    <td class="text-center td-qty bg-white ">Số lượng</td>
                                    <td class="text-center td-price bg-white ">Đơn giá</td>
                                    <td class="text-center td-total bg-white ">Tổng cộng</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION["cart_item"] as $item) {
                                    $item_price = $item["Quantity"] * $item["Price"];
                                    $total_quantity += $item["Quantity"];
                                    $total_price += ($item_price);
                                ?>
                                    <tr>
                                        <td class="text-center td-image bg-white "> <img src="./img/sanpham/<?php echo $item['Pic'] ?>" style="width:60px;height:60px"> </td>
                                        <td class="text-left td-name bg-white "><a href='product-detail.php?id=<?php echo $item['ID'] ?>'><?php echo $item['Name'] ?></a></td>
                                        <td class="text-center td-qty bg-white ">
                                            <div class="input-group btn-block ">
                                                <input type="text" value="<?php echo $item['Quantity'] ?>" size="1" class="quantity custom-form-control">
                                                <span class="input-group-btn">
                                                    <button type="submit" data-toggle="tooltip" class="btn btn-update" onclick="updateQuantity(this,<?php echo $item['ID'] ?>)" data-original-title="Update"><i class="fa fa-refresh"></i></button>
                                                    <button type="button" data-toggle="tooltip" class="btn btn-remove" onclick="removeFromCart(<?php echo $item['ID'] ?>)" data-original-title="Remove"><i class="fa fa-times-circle"></i></button>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-center td-price bg-white  "><?php echo number_format($item['Price'], 0, ".", ".") ?>₫</td>
                                        <td class="text-center td-total bg-white  "><?php echo number_format($item_price, 0, ".", ".") ?>₫</td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td class="cart-total" style="background-color:rgba(238, 238, 238, 1);" colspan="5">
                                        <div>
                                            <div style="padding: 0.5em 0 ">
                                                <span class="float-left w-25"><strong>Tổng tiền: </strong></span>
                                                <span><?php echo number_format($total_price, 0, ".", ".") ?>₫</span>
                                            </div>
                                            <div style="padding: 0.5em 0 ">
                                                <span class="float-left w-25"><strong>Thành tiền: </strong></span>
                                                <span><?php echo number_format($total_price, 0, ".", ".") ?>₫</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<!-- End Cart Detail Section -->

<?php 
    if (isset($_SESSION['isLoginUser'])){
        $email = "";
        foreach($_SESSION['isLoginUser'] as $k => $v){
            $email =  $_SESSION['isLoginUser'][$k]['Email'];
        }
        $sql = "SELECT * FROM user WHERE Email ='".$email."'";
        $result = DataProvider::executeQuery($sql);
        $row = mysqli_fetch_array($result);
        $name = $row['Name'];
        $address = $row['Address'];
        $phone = $row['Phone'];
    }
?>

<!-- Start Checkout Section -->
<section class="checkout-section">
    <div class="container" style="min-height: 300px;" >
        <div class="row">
            <div class="col-md-12" style="background: rgba(240, 242, 245, 1)">
                <div class="mb-2 mt-2">
                    <h3>Thông tin khách hàng</h3>
                </div>
                <form id="customer-info-form">
                    <div class="form-row">
                        <div class="form-group col-md-6">
							<label for="name">Họ và tên:</label>
							<input type="text" id="name" class="form-control" placeholder="Họ và tên" value="<?php echo (isset($_SESSION['isLoginUser']) ? $name : "")?>"></input>
						</div>
                        <div class="form-group col-md-6">
							<label for="phone">Số điện thoại:</label>
							<input type="text" id="phone" class="form-control" placeholder="Số điện thoại" value="<?php echo (isset($_SESSION['isLoginUser']) ? $phone : "")?>"></input>
						</div>
                        <div class="form-group col-md-12">
							<label for="address">Địa chỉ:</label>
							<input type="text" id="address" class="form-control" placeholder="Địa chỉ" value="<?php echo (isset($_SESSION['isLoginUser']) ? $address : "")?>"></input>
                        </div>
                        <div class="form-group col-md-12">
							<label for="note">Ghi chú:</label>
							<textarea id="note" class="form-control"></textarea >
						</div>
                        <div class="col-md-12 btn btn-primary mb-5" onclick="checkOut()">
							<h4> XÁC NHẬN MUA HÀNG </h4>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Checkout Section -->

    <!-- Start Footer Section -->
    <?php
    include './interface/footer.php'
    ?>
    <!-- End Footer Section -->

    <a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>

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

<!-- Mirrored from bestwebcreator.com/ATZShop/demo/product-detail.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 29 Jan 2020 03:54:58 GMT -->

</html>