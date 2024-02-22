<?php
session_start();

if (!isset($_SESSION['ses_id']) || $_SESSION['ses_id'] != session_id()) {
    echo "<script>window.location.replace('login.php')</script>";
}

include("connect.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Poco admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Poco admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <title>SELECT WORM SYSTEM</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="assets/css/fontawesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="assets/css/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="assets/css/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="assets/css/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="assets/css/feather-icon.css">
    <link rel="stylesheet" type="text/css" href="assets/css/animate.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="assets/css/datatables.css">
    <link rel="stylesheet" type="text/css" href="assets/css/owlcarousel.css">
    <link rel="stylesheet" type="text/css" href="assets/css/rating.css">
    <link rel="stylesheet" type="text/css" href="assets/css/pe7-icon.css"> <!-- Plugins css Ends-->
    <link rel="stylesheet" type="text/css" href="assets/css/date-picker.css">
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link id="color" rel="stylesheet" href="assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
    <!-- latest jquery-->
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <style>
        .page-wrapper .page-body-wrapper .iconsidebar-menu .iconMenu-bar li:active .bar-icons:before,
        .page-wrapper .page-body-wrapper .iconsidebar-menu .iconMenu-bar li:focus .bar-icons:before,
        .page-wrapper .page-body-wrapper .iconsidebar-menu .iconMenu-bar li.open .bar-icons:before {
            height: auto;
        }

        .page-wrapper .page-body-wrapper .iconsidebar-menu .iconMenu-bar {
            width: 115px;
        }
    </style>
</head>

<body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="typewriter">
            <h1>New Era Admin Loading..</h1>
        </div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper">
        <?php
        include("header.php");
        ?>
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <?php
            include("sidebar.php");
            ?>

            <div class="page-body" style="margin-left: 6rem !important;">

                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="row">

                        <?php
                        if (isset($_REQUEST['p'])) {
                            include($_REQUEST['p'] . ".php");
                        } else {
                            if ($_SESSION['user_role'] == 2) {
                                include("dashboard.php");
                            } else {
                                include("stock.php");
                            }
                        }

                        ?>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
            <?php
            include("footer.php");
            ?>
        </div>
    </div>

    <!-- Bootstrap js-->
    <script src="assets/js/bootstrap/popper.min.js"></script>
    <script src="assets/js/bootstrap/bootstrap.js"></script>
    <!-- feather icon js-->
    <script src="assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- Sidebar jquery-->
    <!-- <script src="assets/js/sidebar-menu.js"></script> -->
    <script src="assets/js/config.js"></script>
    <!-- Plugins JS start-->
    <script src="assets/js/owlcarousel/owl.carousel.js"></script>
    <script src="assets/js/rating/jquery.barrating.js"></script>
    <script src="assets/js/rating/rating-script.js"></script>
    <script src="assets/js/chat-menu.js"></script>
    <script src="assets/js/ecommerce.js"></script>
    <script src="assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/js/datatable/datatables/datatable.customs1.js"></script>
    <script src="assets/js/chat-menu.js"></script>
    <script src="assets/js/form-validation-custom.js"></script>
    <script src="assets/js/form/product-validation-custom.js"></script>
    <script src="assets/js/form/product-stock-validation-custom.js"></script>
    <script src="assets/js/form/payment-validation-customs.js"></script>
    <script src="assets/js/form/stock-validation-custom.js"></script>
    <script src="assets/js/form/users-validation-custom.js "></script>
    <script src="assets/js/datepicker/date-picker/datepicker.js"></script>
    <script src="assets/js/datepicker/date-picker/datepicker.en.js"></script>
    <script src="assets/js/datepicker/date-picker/datepicker.custom.js"></script>
    <script src="assets/js/chart/apex-chart/apex-chart.js"></script>
    <script src="assets/js/chart/apex-chart/stock-prices.js"></script>
    <script src="assets/js/chart/apex-chart/chart-customss.js"></script>

    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/theme-customizer/customizers.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- login js-->
    <!-- Plugin used-->
</body>

</html>