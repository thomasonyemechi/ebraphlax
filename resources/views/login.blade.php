<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="shortcut icon" href="">
    <title>Login | Clanvent</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://clanvent-alpha.laravel-script.com/public/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://clanvent-alpha.laravel-script.com/public/admin/css/icons.css">
    <link rel="stylesheet" href="https://clanvent-alpha.laravel-script.com/public/admin/css/slick.css">
    <!-- main css -->
    <link rel="stylesheet" href="https://clanvent-alpha.laravel-script.com/public/admin/css/style.css">
    <link rel="stylesheet" href="https://clanvent-alpha.laravel-script.com/public/admin/css/custom.css">
    <link rel="stylesheet" href="https://clanvent-alpha.laravel-script.com/public/admin/css/login-responsive.css">
    <style>
        :root {
            /*#28aaa9*/
            --primary-color: #000000;
            /*#2b2d5d*/
            --secondary-color: #000000;
        }
    </style>
</head>

<body class="body_color">

    <section class="ic_main_form_area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 d-none d-lg-block">
                    <div class="ic-fxied-image">
                        <div class="login-img-slider-heads">
                            <div class="img-items">
                                <img src=https://clanvent-alpha.laravel-script.com/public/admin/images/1.png
                                    class="img-fluid" alt="slider-img">
                            </div>
                            <div class="img-items">
                                <img src=https://clanvent-alpha.laravel-script.com/public/admin/images/2.png
                                    class="img-fluid" alt="slider-img">
                            </div>
                            <div class="img-items">
                                <img src=https://clanvent-alpha.laravel-script.com/public/admin/images/3.png
                                    class="img-fluid" alt="slider-img">
                            </div>
                        </div>
                        <div class="mobile-img-slider-heads">
                            <div class="img-items">
                                <img src=https://clanvent-alpha.laravel-script.com/public/admin/images/M1.png
                                    class="img-fluid" alt="slider-img">
                            </div>
                            <div class="img-items">
                                <img src=https://clanvent-alpha.laravel-script.com/public/admin/images/M2.png
                                    class="img-fluid" alt="slider-img">
                            </div>
                            <div class="img-items">
                                <img src=https://clanvent-alpha.laravel-script.com/public/admin/images/M3.png
                                    class="img-fluid" alt="slider-img">
                            </div>
                        </div>
                        <img class="img-fluid w-100"
                            src="https://clanvent-alpha.laravel-script.com/public/admin/images/Slider_Frame.png"
                            alt="slider-img">
                    </div>
                </div>
                <div class="col-lg-5 col-md-7 m-auto ml-lg-auto">
                    <div class="ic_main_form_inner">
                        <div class="form_box">
                            <div class="col-lg-12">
                                <img class="img-fluid ic-login-img"
                                    src="https://clanvent-alpha.laravel-script.com/public/admin/images/logo.png"
                                    alt="imgs">


                                <h2>Login</h2>
                                <p>Manage your business with our automated Inventory Management System</p>
                            </div>



                            <form class="row login_form justify-content-center"
                                action="https://clanvent-alpha.laravel-script.com/admin/login" method="post"
                                id="loginForm" novalidate="novalidate">

                                <input type="hidden" name="_token" value="tWjPPFrsY5oiZE4gBuUbKG1AGlm6Tl80GUu7fvEt">
                                <div class="form-group col-lg-12">
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="demo@app.com">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password">
                                    <i class="fa fa-unlock-alt" aria-hidden="true"></i>

                                </div>
                                <div class="form-group col-lg-12">
                                    <button type="submit" value="submit"
                                        class="btn submit_btn form-control">Login</button>
                                </div>
                                <div class="form-group col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <a href="javascript:void(0)" data-value="admin"
                                                class="btn btn-primary btn-oneclick-login form-control">Admin Login </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="javascript:void(0)" data-value="customer"
                                                class="btn btn-primary btn-oneclick-login form-control">Customer Login
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="text-center login-form-footer">© 2024 All Right Reserved | Design &amp; Developed by
                            <a class="ic-main-color" href="https://itclanbd.com/"><span class="d-block">ITclan
                                    BD</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Login Form Area =================-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://clanvent-alpha.laravel-script.com/public/admin/js/jquery.min.js"></script>
    <script src="https://clanvent-alpha.laravel-script.com/public/admin/js/bootstrap.bundle.min.js"></script>
    <script src="https://clanvent-alpha.laravel-script.com/public/admin/js/slick.min.js"></script>
    <!-- Extra Plugin CSS -->
    <script src="https://clanvent-alpha.laravel-script.com/public/admin/js/login-slider.js"></script>

</body>

</html>
