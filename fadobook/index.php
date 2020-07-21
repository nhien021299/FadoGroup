<?php
session_start();
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
    <link rel="icon" type="image/png" sizes="100x100" href="img/favicon.png">
    <!-- Animation CSS -->
    <link rel="stylesheet" href="css/animate.css" type="text/css">
    <!-- Font Css -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="css/font-awesome.css" type="text/css" rel="stylesheet">
    <link href="css/ionicons.min.css" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Crimson+Text|Work+Sans:400,700" rel="stylesheet">
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
    <title>FadoBook.vn</title>

    <script src=".\js\jquery-3.4.1.min.js"></script>

    <link href="css/custom/CSS-index.css" type="text/css" rel="stylesheet">

</head>

<body class="theme-3">
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

    <!-- Start Slider Section -->
    <section class="slider slider-type-2 p-0 mx-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 slider-width">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $sql = "SELECT * FROM banner WHERE Position = 'Slider-Section'  ORDER BY ID ASC";
                            $result = DataProvider::executeQuery($sql);
                            $numOfSlide = 0;
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <div class="carousel-item <?php echo ($numOfSlide == 0 ? "active" : "") ?>">
                                    <a href="<?php echo $row['Link'] ?>" class="w-100">
                                        <img src="img/banner/<?php echo $row['Image'] ?>" class="img-slider"></img>
                                    </a>
                                </div>
                            <?php
                                $numOfSlide++;
                            }
                            ?>
                        </div>
                        <ol class="carousel-indicators">
                            <?php
                            for ($i = 0; $i < $numOfSlide; $i++) {
                            ?>
                                <li data-target="#carouselExampleControls" data-slide-to="<?php echo $i ?>" class="<?php echo ($i == 0  ? "active" : "") ?>"></li>
                            <?php

                            }
                            ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Slider Section -->

    <!-- Start Service Section -->
    <section class="bg-white section-shadow">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 facility-box">
                    <div class="facility-inner ">
                        <div class="fb-icon text-center w-25">
                            <img src="img/i_giaohang.png" width="75px"></img>
                        </div>
                        <div class="fb-text w-75">
                            <h7>GIAO HÀNG TOÀN QUỐC</h3>
                                <span>Hỗ trợ 63 tỉnh thành trên toàn quốc</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 facility-box">
                    <div class="facility-inner">
                        <div class="fb-icon text-center w-25">
                            <img src="img/i_thanhtoan.png" width="75px"></img>
                        </div>
                        <div class="fb-text w-75">
                            <h7>THANH TOÁN DỄ DÀNG</h7>
                            <span>Chuyển khoản ngân hàng hoặc thanh toán khi nhận hàng</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 facility-box">
                    <div class="facility-inner">
                        <div class="fb-icon text-center w-25">
                            <img src="img/i_uudai.png" width="75px"></img>
                        </div>
                        <div class="fb-text w-75">
                            <h7>ƯU ĐÃI MUA NHÓM</h7>
                            <span>Dành cho đối tác Nhà phân phối, cafe board game, trường học</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Service Section -->

    <!-- Start Deals Section -->
    <section class="deals-section section-shadow bg-white">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="title">
                        <h4>Sản phẩm mới</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-7">
                    <div class="products-slider4 products-style-2 nav-style-2 owl-carousel owl-theme h-100" data-margin="30" data-dots="false" data-autoplay="false" data-nav="true" data-loop="false">
                        <?php
                        $sql = "SELECT * FROM product WHERE Status = 0 ORDER BY ID DESC  LIMIT 0,10"; //ASC
                        $result = DataProvider::executeQuery($sql);
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <div class='item'>
                                <div class='product-box common-cart-box'>
                                    <div class='product-img common-cart-img'>
                                        <img src='img/sanpham/<?php echo $row['Pic'] ?>' alt='product-img' class=''>
                                        <div class="hover-option">
                                            <ul class="hover-icon">
                                                <li><a onclick='addToCart("<?php echo  $row['ID'] ?>")' class='text-white'><i class="fa fa-shopping-cart"></i></a></li>
                                                <li><a href="#quickview-popup" onclick='quickView("<?php echo  $row['ID']  ?>")' class="quickview-popup-link"><i class="fa fa-eye"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-info common-cart-info">
                                        <a href="product-detail.php?id=<?php echo  $row['ID'] ?>" class="cart-name"><?php echo  $row['Name'] ?></a>
                                        <p class="cart-price"><?php echo number_format($row['Price'], 0, ".", ".") ?>₫</p>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-5">
                    <div class="carousel_slide1 shop-hover-style-2 owl-carousel owl-theme mt-3 mt-sm-0" data-dots="false">
                        <?php
                        $sql = "SELECT * FROM banner WHERE Position = 'Slider-Deals-Section'  ORDER BY ID ASC";
                        $result = DataProvider::executeQuery($sql);
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <a href="<?php echo $row['Link'] ?>" class="offer-banner slideable-offer-banner shop-hover">
                                <img src="img/banner/<?php echo $row['Image'] ?>" alt="offer-banner">
                            </a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Deals Section -->

    <!-- Start Offer Banner Section -->
    <section class="offer-section  shop-hover-style-2 section-shadow bg-white">
        <div class="container-fluid">
            <div class="row">
                <?php
                $sql = "SELECT * FROM banner WHERE Position = 'Offer-Section'  ORDER BY ID ASC";
                $result = DataProvider::executeQuery($sql);
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <div class="col-md-4">
                        <a href="<?php echo $row['Link'] ?>" class="offer-banner shop-hover">
                            <img src="img/banner/<?php echo $row['Image'] ?>" alt="offer-banner">
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
    <!-- End Offer Banner Section -->

    <!-- Start Popular Products Section -->
    <section class="products-section  section-shadow bg-white">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="title">
                        <h4>Tiểu thuyết bán chạy</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="carousel_slide6 products-style-2 nav-style-2 owl-carousel owl-theme" data-margin="30" data-dots="false" data-autoplay="false" data-nav="true" data-loop="false">
                        <?php
                        $sql = "SELECT DISTINCT * FROM product 
                                WHERE ID IN 
                                    (SELECT ProductID FROM billdetail GROUP BY ProductID ORDER BY SUM(Quantity) DESC)
                                AND Status = 0  
                                AND Type = 'TT' 
                                LIMIT 0,10"; //ASC
                        /*$sql = "SELECT * FROM product WHERE STATUS = 0 ORDER BY ID ASC";*/
                        $result = DataProvider::executeQuery($sql);
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <div class='item'>
                                <div class='product-box common-cart-box'>
                                    <div class='product-img common-cart-img'>
                                        <img src='img/sanpham/<?php echo $row['Pic'] ?>' alt='product-img' class=''>
                                        <div class="hover-option">
                                            <ul class="hover-icon">
                                                <li><a onclick='addToCart("<?php echo  $row['ID'] ?>")' class='text-white'><i class="fa fa-shopping-cart"></i></a></li>
                                                <li><a href="#quickview-popup" onclick='quickView("<?php echo  $row['ID']  ?>")' class="quickview-popup-link"><i class="fa fa-eye"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-info common-cart-info">
                                        <a href="product-detail.php?id=<?php echo  $row['ID'] ?>" class="cart-name"><?php echo  $row['Name'] ?></a>
                                        <p class="cart-price"><?php echo number_format($row['Price'], 0, ".", ".") ?>₫</p>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Popular Products Section -->

    <!-- Start Popular Products Section -->
    <section class="products-section  section-shadow bg-white">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="title">
                        <h4>Manga Bán chạy</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="carousel_slide6 products-style-2 nav-style-2 owl-carousel owl-theme" data-margin="30" data-dots="false" data-autoplay="false" data-nav="true" data-loop="false">
                        <?php
                        $sql = "SELECT DISTINCT * FROM product 
                                WHERE ID IN 
                                    (SELECT ProductID FROM billdetail GROUP BY ProductID ORDER BY SUM(Quantity) DESC)
                                AND Status = 0  
                                AND Type = 'MG' 
                                LIMIT 0,10"; //ASC
                        /*$sql = "SELECT * FROM product WHERE STATUS = 0 ORDER BY ID ASC";*/
                        $result = DataProvider::executeQuery($sql);
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <div class='item'>
                                <div class='product-box common-cart-box'>
                                    <div class='product-img common-cart-img'>
                                        <img src='img/sanpham/<?php echo $row['Pic'] ?>' alt='product-img' class=''>
                                        <div class="hover-option">
                                            <ul class="hover-icon">
                                                <li><a onclick='addToCart("<?php echo  $row['ID'] ?>")' class='text-white'><i class="fa fa-shopping-cart"></i></a></li>
                                                <li><a href="#quickview-popup" onclick='quickView("<?php echo  $row['ID']  ?>")' class="quickview-popup-link"><i class="fa fa-eye"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-info common-cart-info">
                                        <a href="product-detail.php?id=<?php echo  $row['ID'] ?>" class="cart-name"><?php echo  $row['Name'] ?></a>
                                        <p class="cart-price"><?php echo number_format($row['Price'], 0, ".", ".") ?>₫</p>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Popular Products Section -->

    <!-- Start Popular Products Section -->
    <section class="products-section  section-shadow bg-white">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="title">
                        <h4>Sách kỹ năng sống bán chạy</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="carousel_slide6 products-style-2 nav-style-2 owl-carousel owl-theme" data-margin="30" data-dots="false" data-autoplay="false" data-nav="true" data-loop="false">
                        <?php
                        $sql = "SELECT DISTINCT * FROM product 
                                WHERE ID IN 
                                    (SELECT ProductID FROM billdetail GROUP BY ProductID ORDER BY SUM(Quantity) DESC)
                                AND Status = 0  
                                AND Type = 'KNS' 
                                LIMIT 0,10"; //ASC
                        /*$sql = "SELECT * FROM product WHERE STATUS = 0 ORDER BY ID ASC";*/
                        $result = DataProvider::executeQuery($sql);
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <div class='item'>
                                <div class='product-box common-cart-box'>
                                    <div class='product-img common-cart-img'>
                                        <img src='img/sanpham/<?php echo $row['Pic'] ?>' alt='product-img' class=''>
                                        <div class="hover-option">
                                            <ul class="hover-icon">
                                                <li><a onclick='addToCart("<?php echo  $row['ID'] ?>")' class='text-white'><i class="fa fa-shopping-cart"></i></a></li>
                                                <li><a href="#quickview-popup" onclick='quickView("<?php echo  $row['ID']  ?>")' class="quickview-popup-link"><i class="fa fa-eye"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-info common-cart-info">
                                        <a href="product-detail.php?id=<?php echo  $row['ID'] ?>" class="cart-name"><?php echo  $row['Name'] ?></a>
                                        <p class="cart-price"><?php echo number_format($row['Price'], 0, ".", ".") ?>₫</p>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Popular Products Section -->

    <!-- Start Instagram Section -->
    <section class="instagram-section p-0 mx-0 mb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 p-0">
                    <div class="insta-slider-2 owl-carousel owl-theme">
                        <div class="insta-img">
                            <img src="img/sendo.jpg" alt="insta-img">
                        </div>
                        <div class="insta-img">
                            <img src="img/shopee.jpg" alt="insta-img">
                        </div>
                        <div class="insta-img">
                            <img src="img/lazada.jpg" alt="insta-img">
                        </div>
                        <div class="insta-img">
                            <img src="img/phuongnam.jpg" alt="insta-img">
                        </div>
                        <div class="insta-img">
                            <img src="img/fahasha.jpg" alt="insta-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Instagram Section -->
    <br>
    <!-- Start Newsletter Section -->
    <section class="pt_medium pb_medium navy-dark-bg m-0 px-0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="text-white mb-3 mb-md-0">
                        <h5 class="mb-2">Cập Nhật Tin Tức Cùng FADO SÁCH VN</h5>
                        <p>Bạn hãy đăng ký email để cập nhật tin tức khuyến mãi từ chúng tôi</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <form class="newsletter-form">
                        <div class="outline-input">
                            <input type="text" required="" placeholder="Nhập Email">
                        </div>
                        <button type="submit" title="Subscribe" class="btn btn-submit border-0 btn-primary" name="submit" value="Submit">Theo Dõi</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End Newsletter Section -->

    <!-- Start Footer Section -->
    <?php
    include './interface/footer.php'
    ?>
    <!-- End Footer Section -->

    <!-- Start Quickview Popup Section -->
    <?php
    include './interface/quickview.php'
    ?>
    <!-- End Quickview Popup Section -->


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

    <script src="./js/custom/JS-index.js"></script>

    <script src="./js/custom/JS-cart.js"></script>
    <script src="./js/custom/JS-user.js"></script>

</body>

</html>