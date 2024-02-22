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
    <title>Poco - Premium Admin Template</title>
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
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link id="color" rel="stylesheet" href="assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
</head>

<body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="typewriter">
            <h1>Welcome Loading..</h1>
        </div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="authentication-main">
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div class="auth-innerright auth-minibox">
                            <div class="reset-password-box">
                                <div class="card mt-4 mb-0">
                                    <div class="card-body p-0">
                                        <h4>ForgotPassword</h4>
                                        <form class="theme-form" action="action/ac_login.php?ac=forgot" onsubmit="return forgot()" id="form" method="POST">
                                            <h6 class="f-14 mt-4 mb-3">Enter your username</h6>
                                            <div class="form-group">
                                                <label class="col-form-label">Your Username</label>
                                                <input class="form-control" type="text" name="user_username">
                                            </div>
                                            <!-- <div class="form-group">
                                                <label class="col-form-label">New Password</label>
                                                <input class="form-control" type="password" name="new-mem_password">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Retype Password</label>
                                                <input class="form-control" type="password" name="mem_password">
                                            </div> -->
                                            <div class="form-group form-row mb-2">
                                                <div class="col-md-2">
                                                    <button class="btn btn-primary" type="submit">Done</button>
                                                </div>
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
    </div>
    <!-- latest jquery-->
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap js-->
    <script src="assets/js/bootstrap/popper.min.js"></script>
    <script src="assets/js/bootstrap/bootstrap.js"></script>
    <!-- feather icon js-->
    <script src="assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- Sidebar jquery-->
    <script src="assets/js/sidebar-menu.js"></script>
    <script src="assets/js/config.js"></script>
    <!-- Plugins JS start-->
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/theme-customizer/customizers.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- login js-->
    <!-- Plugin used-->

    <script>
        function forgot() {
            let url = $("#form").attr("action")
            let data = $('#form').serialize();
            $.ajax({
                url: url, //the page containing php script
                type: "post", //request type,
                // dataType: 'json',
                data: data,
                success: function(res) {
                    let {
                        status,
                        message,
                        userId
                    } = JSON.parse(res)
                    console.log(JSON.parse(res))

                    if (status) {
                        Swal.fire({
                            title: message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1000,
                        }).then(() => {
                            window.location.replace(`resetPassword.php?userId=${userId}`)
                        })
                    } else {
                        Swal.fire({
                            title: message,
                            icon: "error",
                            showConfirmButton: false
                        })

                    }

                }
            });
            return false
        }
    </script>
</body>

</html>