<?php
session_start();
if (!isset($_REQUEST['id']) || $_REQUEST['id'] == "") {
    header("Location: index.php");
    exit;
}
require_once './php/DataProvider.php';
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
    <link href="css/custom/CSS-product-detail.css" type="text/css" rel="stylesheet">
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

    <!-- Start Breadcrumbs Section 
<section class="breadcrumbs-section background_bg" data-img-src="image/pd-breadcrumbs-img.jpg">
	<div class="container">
    	<div class="row">
        	<div class="col-md-12">
                <div class="page_title text-center">
                	<h1>Product Detail</h1>
                    <ul class="breadcrumb justify-content-center">
                    	<li><a href="index.html">home</a></li>
                        <li><a href="#">Shop</a></li>
                        <li><span>Product Detail</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Header Section -->

    <!-- Start Product Detail Section -->
    <?php
    if (isset($_REQUEST['id'])) {
        $allPictures = array();
        $id = $_REQUEST['id'];
        $sql = "SELECT * FROM product where ID='" . $id . "'";
        $result = DataProvider::executeQuery($sql);
        $row = mysqli_fetch_array($result);
        $name = $row['Name'];
        $description = $row['Description'];
        $time = $row['Time'];
        $type = $row['Type'];
        $image = $row['Pic'];
        $price = $row['Price'];
        $quantity = $row['Quantity'];
        $status = $row['Status'];
        $author = $row['Author'];
        $category = $row['Category'];
        //$soluong = $row['SoLuong'];
        array_push($allPictures, $row['Pic']);
        $sql = "SELECT * FROM images where ProductID=\"" . $id . "\"";
        $result = DataProvider::executeQuery($sql);
        while ($row = mysqli_fetch_array($result)) {
            array_push($allPictures, $row['Image']);
        }
    }
    ?>
    <section class="products-detail-section pt_large">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="product-image" style="height: 445px;">
                        <img class="product_img" src='img/sanpham/<?php echo $allPictures[0] ?>' data-zoom-image="img/sanpham/<?php echo $allPictures[0] ?>" style="width:100%;height:100%" />
                    </div>
                    <div id="pr_item_gallery" class="product_gallery_item owl-thumbs-slider owl-carousel owl-theme">
                        <?php
                        foreach ($allPictures as $value) {
                            echo "<div class='item'>" .
                                "<a href='#' data-image='img/sanpham/" . $value . "' data-zoom-image='img/sanpham/" . $value . "'>" .
                                "<img src='img/sanpham/" . $value . "' />" .
                                "</a>" .
                                "</div>";
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="quickview-product-detail">
                        <div class="box-title"><?php echo $name ?></div>
                        <hr>
                        <div class="box-price">Giá: <p><?php echo number_format($price, 0, ".", ".") ?>₫</p>
                        </div>
                        <div class="box-attribute">
                            <div class="attribute-item">
                                <p class="attribute-title">Tác giả:</p>
                                <p class="attribute-content"><?php echo $author ?></p>
                            </div>
                            <div class="attribute-item">
                                <p class="attribute-title">Ngày xuất bản:</p>
                                <p class="attribute-content"><?php echo $time ?></p>
                            </div>
                            <div class="attribute-item">
                                <p class="attribute-title">Loại sách:</p>
                                <p class="attribute-content">
                                    <?php switch ($type)
                                        {
                                            case "TT":
                                                echo "Tiểu Thuyết";
                                                break;
                                            case "MG":
                                                echo "Manga";
                                                break;
                                            case "KNS":
                                                echo "Kỹ Năng Sống";
                                                break;
                                        } 
                                    ?>
                                </p>
                            </div>
                            <div class="attribute-item">
                                <p class="attribute-title">Thể loại:</p>
                                <p class="attribute-content">
                                    <?php switch ($category )
                                     {
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
                                </p>
                            </div>
                        </div>
                        <hr>
                        <p class="stock">Trạng thái: <span>Còn <?php echo $quantity ?> sản phẩm</span></p>
                        <div class="quantity-box">
                            <p>Số lượng:</p>
                            <div class="input-group">
                                <input type="button" value="-" class="minus">
                                <input id="quantity" class="quantity-number qty" type="text" value="1" min="1">
                                <input type="button" value="+" class="plus">
                            </div>
                            <div class="quickview-cart-btn">
                                <button class="btn btn-primary" onclick="addToCart(<?php echo $id ?>)" <?php echo ($quantity != 0 ? "" : "disabled") ?>><img src="img/cart-icon-1.png"> Thêm vào giỏ hàng</button>
                            </div>
                        </div>
                        <div class="box-social-like d-sm-flex justify-content-between">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Product Detail Section -->

    <!-- Start Product Tabs Section -->
    <section class="products-detail-tabs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="products-tabs">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="discription-tab" data-toggle="tab" href="#discription" role="tab" aria-controls="discription" aria-selected="true">Mô tả</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Bình luận ()</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade tab-1 show active" id="discription" role="tabpanel" aria-labelledby="discription-tab">
                                <div class="tab-title">
                                    <h6>Mô tả</h6>
                                </div>
                                <div class="tab-caption">
                                    <p><?php echo $description ?></p>
                                </div>
                            </div>
                            <div class="tab-pane fade tab-2" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <div class="tab-title">
                                    <h6>Bình luận</h6>
                                </div>
                                <div class="tab-caption">
                                    <div class="costomer-reviews">
                                        <div class="costomer-reviews-box">
                                            <div class="reviews-img">
                                                <img src="image/costomer-img.jpg" alt="costomer-img">
                                            </div>
                                            <div class="reviews-text">
                                                <p class="reviewer-name">admin</p>
                                                <span class="reviews-date">September 13, 2017</span>
                                                <p class="reviewer-text">24/7 helpdesk is also available. I Love it!</p>
                                            </div>
                                        </div>
                                        <div class="costomer-reviews-box">
                                            <div class="reviews-img">
                                                <img src="image/costomer-img.jpg" alt="costomer-img">
                                            </div>
                                            <div class="reviews-text">
                                                <p class="reviewer-name">admin</p>
                                                <span class="reviews-date">September 13, 2017</span>
                                                <p class="reviewer-text">24/7 helpdesk is also available. I Love it!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-caption">
                                    <div class="add-review">
                                        <div class="tab-title">
                                            <h6>Add a review</h6>
                                        </div>
                                        <form class="add-review-form">
                                            <div class="input-1">
                                                <input required class="form-control" placeholder="Enter Your Name" value="" type="text">
                                            </div>
                                            <div class="input-2">
                                                <input required class="form-control" placeholder="Enter Your Email" value="" type="email">
                                            </div>
                                            <div class="input-3">
                                                <textarea required rows="6" class="form-control" placeholder="Enter Your Review"></textarea>
                                            </div>
                                            <div class="input-btn">
                                                <button type="submit" class="btn btn-secondary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Product Tabs Section -->

    <!-- Start Related Product Section -->
    <section class="related-product pb_large" style="border-bottom: 1px solid #cdcdcd">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title">
                        <h4>Sản phẩm liên quan</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="products-slider4 same-nav owl-carousel owl-theme" data-margin="30" data-dots="false">
                        <?php
                        $sql = "SELECT * FROM product WHERE Type ='" . $type . "' ORDER BY ID DESC LIMIT 0,8";
                        $result = DataProvider::executeQuery($sql);
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <div class="item">
                                <div class="product-box common-cart-box">
                                    <div class="product-img common-cart-img">
                                        <img src="img/sanpham/<?php echo $row['Pic'] ?>" alt="product-img" class="img-product">
                                        <div class="hover-option">
                                            <div class="add-cart-btn">
                                                <a href="#" onclick="addToCart(<?php echo $row['ID'] ?>)" class="btn btn-primary">Thêm vào giỏ hàng</a>
                                            </div>
                                            <ul class="hover-icon">
                                                <li><a href="#quickview-popup" onclick="quickView(<?php echo $row['ID'] ?>)" class="quickview-popup-link"><i class="fa fa-eye"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-info common-cart-info text-center">
                                        <a href="product-detail.php?id=<?php echo $row['ID'] ?>" class="cart-name"><?php echo $row['Name'] ?></a>
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
    <!-- End Related Product Section -->

    <!-- Start Footer Section -->
    <?php
    include './interface/footer.php'
    ?>
    <!-- End Footer Section -->

    <!-- Start QuickView Section -->
    <?php
    include './interface/quickview.php'
    ?>
    <!-- End QuickView Section -->

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