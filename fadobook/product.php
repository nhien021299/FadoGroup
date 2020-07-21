<?php
session_start();
if (!isset($_REQUEST['code']) || $_REQUEST['code'] == "") {
    $_REQUEST['code'] = 'TT';
}
$numberOfItemsInOnePage = 20;
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
    $typeName = $_REQUEST['code'];
    ?>
    <!-- Start Product Section -->
    <section class="products-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2 mb-5">
                    <div class="sorting">
                        <div class="form-group col-md-12">
                            <label for="sortBasic">Sắp xếp theo:</label>
                            <select id="sortBasic" class="form-control" onchange="paginationGetData(<?php echo $numberOfItemsInOnePage ?>,1)">
                                <option value='0'>Mặc định</option>
                                <option value='1'>Tên (A - Z)</option>
                                <option value='2'>Tên (Z - A)</option>
                                <option value='3'>Giá (Thấp - Cao)</option>
                                <option value='4'>Giá (Cao - Thấp)</option>
                            </select>
                        </div>
                        <input type="hidden" id="sortType" value="<?php echo $_REQUEST['code'] ?>"></input>
                        <input type="hidden" id="sortCategory" value="<?php echo $_REQUEST['category'] ?>"></input>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="title mb-4">
                        <h2><?php
                            switch ($typeName) {
                                case "HH":
                                    echo "Huyền Huyễn";
                                    break;
                                case "HD":
                                    echo "Hành Động";
                                    break;
                                case "KNS":
                                    echo "Kỹ Năng Sống";
                                    break;
                                case "KH":
                                    echo "Kiếm Hiệp";
                                    break;
                            }
                            ?>
                        </h2>
                    </div>
                    <div class="row" id="product-container">
                        <?php
                        $sql = "SELECT * FROM product WHERE Status = 0 AND Type='".$_REQUEST['code']."' ";
                        if(isset($_REQUEST['category'])){
                            $sql .= "AND Category ='".$_REQUEST['category']."'";
                        }
                        $sql .= " LIMIT 0," . $numberOfItemsInOnePage;
                        $result = DataProvider::executeQuery($sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <div class="col-md-3 mb-5">
                                <div class="item">
                                    <div class="product-box common-cart-box">
                                        <div class="product-img common-cart-img">
                                            <img src="./img/sanpham/<?= $row['Pic'] ?>" alt="product-img" class="img-product">
                                            <div class="hover-option">
                                                <ul class="hover-icon">
                                                    <li><a href="#" onclick='addToCart(<?= $row['ID'] ?>)'><i class="fa fa-shopping-cart"></i></a></li>
                                                    <li><a href="#quickview-popup" class="quickview-popup-link" onclick='quickView(<?= $row['ID'] ?>)'><i class="fa fa-eye"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-info common-cart-info" style="text-align: center;">
                                            <a href="product-detail.php?id=<?= $row['ID'] ?>" class="cart-name"><?= $row['Name'] ?></a>
                                            <p class="cart-price"><?= number_format($row['Price'], 0, ".", ".") ?>₫</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div id="pagination-section">
                        <?php
                        $sql = "SELECT count(*) FROM product WHERE Status = 0 AND Type ='" . $_REQUEST['code'] . "'";
                        if(isset($_REQUEST['category'])){
                            $sql .= " AND Category ='".$_REQUEST['category']."'";
                        }
                        $result = DataProvider::executeQuery($sql);
                        $numberOfItems = mysqli_num_rows($result); //number of items
                        $numberOfPages = ceil($numberOfItems / $numberOfItemsInOnePage); //Number of pages = lam tron len
                        if ($numberOfPages > 1) {
                        ?>
                            <ul class="pagination">
                                <li class="text">
                                    <!--<a href="#" title="Trang đầu">&lt;&lt;</a>
                            <a href="#" title="Trang trước">&lt;</a>-->
                                    <?php
                                    for ($page = 1; $page <= $numberOfPages; $page++) {
                                    ?>
                                        <a href="#" onclick='paginationGetData(<?php echo $numberOfItemsInOnePage ?>,<?php echo $page ?>)' <?php if ($page == 1) echo 'class="active"' ?>><?= $page ?></a>
                                    <?php
                                    }
                                    ?>
                                    <a href="#" onclick='paginationGetData(<?php echo $numberOfItemsInOnePage ?>,2)' title="Trang sau">&gt;</a>
                                    <a href="#" onclick='paginationGetData(<?php echo $numberOfItemsInOnePage ?>,<?php echo $numberOfPages ?>)' title="Trang cuối">&gt;&gt;</a>
                                </li>
                            </ul>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Product Section -->


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