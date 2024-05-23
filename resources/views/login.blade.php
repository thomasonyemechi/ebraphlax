<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="">
    <title>Login</title>

    <link href="{{ asset('assets/css/bootstrap.min.css ') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/slick.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/fonts/flaticon/font/flaticon.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

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
            <div class="row justify-content-center p-0 m-0 ">
                <div class=" col-md-5 ">
                    <div class="ic_main_form_inner" style="width: 100% !important">
                        <div class="form_box">
                            <h2>Login</h2>
                            <p>Enter your login credentials to Manage {{ ucwords(env('APP_NAME')) }} </p>



                            <form class=" login_form justify-content-center" action="/user_login" method="post"
                                id="loginForm" novalidate="novalidate"> @csrf
                                <div class="form-group col-lg-12">
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="admin@agmail.com">
                                    <i class="fa fa-user"></i>
                                </div>

                                @error('email')
                                    <div class="form-group col-lg-12" style="padding-left: 0px">
                                        <i class="text-danger small "
                                            style="padding-left: 0px !important; margin-left: 0px !mportant">
                                            {{ $message }} </i>
                                    </div>
                                @enderror

                                <div class="form-group col-lg-12">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password">
                                    <i class="fa fa-unlock-alt" aria-hidden="true"></i>

                                </div>

                                @error('password')
                                    <div class="form-group col-lg-12" style="padding-left: 0px">
                                        <i class="text-danger small "
                                            style="padding-left: 0px !important; margin-left: 0px !mportant">
                                            {{ $message }} </i>


                                    </div>
                                @enderror


                                <div class="col-md-12">
                                    <div class="d-flex justify-content-end ">
                                        <a href="/reset-order">Reset Password</a>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <button type="submit" value="submit"
                                        class="btn submit_btn form-control">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('assets/js/custom.js?v=3.5') }}"></script>
    <script src="{{ asset('assets/js/custom-dev.js?v=3.5') }}"></script>

</body>

</html>
