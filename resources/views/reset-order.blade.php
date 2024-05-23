@php
    $stage = isset($_GET['reset_stage']) ? $_GET['reset_stage'] : 1;
@endphp
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="">
    <title>Reset Password</title>

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
                            @if ($stage == 3)
                                <h2>Reset Password</h2>
                                <p>Enter the code that was sent to you also enter your new password</p>
                            @else
                                <h2>Reset Password</h2>
                                <p>Enter your phone number to get reset code</p>
                            @endif


                            @if (session('success'))
                                <div class="alert bg-success">
                                    {{ session('success') }}
                                </div>
                            @elseif(session('error'))
                                <div class="alert bg-danger">
                                    {{ session('error') }}
                                </div>
                            @endif





                            @if ($stage == 3)
                                <form class=" login_form justify-content-center" action="/reset_password" method="post"
                                    id="loginForm" novalidate="novalidate"> @csrf

                                    <div class="form-group col-lg-12">
                                        <label for="">Reset Code</label>
                                        <input type="number" class="form-control" name="reset_code"
                                            placeholder="******">
                                        <i class="fa mt-3 fa-user"></i>
                                    </div>

                                    @error('reset_code')
                                        <div class="form-group col-lg-12" style="padding-left: 0px">
                                            <i class="text-danger small "
                                                style="padding-left: 0px !important; margin-left: 0px !mportant">
                                                {{ $message }} </i>
                                        </div>
                                        <div class=" mt-5" style="padding-left: 0px">
                                        </div>
                                    @enderror



                                    <div class="form-group col-lg-12">
                                        <label for="">Password</label>
                                        <input type="password" class="form-control" name="password"
                                            placeholder="******">
                                        <i class="fa fa-key mt-3"></i>
                                    </div>

                                    @error('password')
                                        <div class="form-group col-lg-12" style="padding-left: 0px">
                                            <i class="text-danger small "
                                                style="padding-left: 0px !important; margin-left: 0px !mportant">
                                                {{ $message }} </i>
                                        </div>
                                        <div class=" mt-5" style="padding-left: 0px">
                                        </div>
                                    @enderror



                                    <div class="form-group col-lg-12">
                                        <label for="">Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                            placeholder="******">
                                        <i class="fa fa-key mt-3"></i>
                                    </div>

                                    @error('password_confirmation')
                                        <div class="form-group col-lg-12" style="padding-left: 0px">
                                            <i class="text-danger small "
                                                style="padding-left: 0px !important; margin-left: 0px !mportant">
                                                {{ $message }} </i>
                                        </div>
                                    @enderror


                                    {{-- <div class="d-flex justify-content-end ">
                                        <a href="">Request Code in 59s</a>
                                    </div> --}}


                                    <div class="form-group  col-lg-12">
                                        <button type="submit" value="submit" class="btn submit_btn form-control">Reset
                                            Password</button>

                                        <div class="d-flex justify-content-end ">
                                            <a href="/login">Proceed to Login</a>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <form class=" login_form justify-content-center" action="/get_reset_code" method="post"
                                    id="loginForm" novalidate="novalidate"> @csrf
                                    <div class="form-group col-lg-12">
                                        <input type="tel" class="form-control" name="phone"
                                            placeholder="0903--00000000">
                                        <i class="fa fa-user"></i>
                                    </div>

                                    @error('phone')
                                        <div class="form-group col-lg-12" style="padding-left: 0px">
                                            <i class="text-danger small "
                                                style="padding-left: 0px !important; margin-left: 0px !mportant">
                                                {{ $message }} </i>
                                        </div>
                                    @enderror


                                    <div class="form-group col-lg-12">
                                        <button type="submit" value="submit" class="btn submit_btn form-control">Get
                                            Reset
                                            Code</button>
                                        <div class="d-flex justify-content-end ">
                                            <a href="/login">Login</a>
                                        </div>


                                    </div>
                                </form>
                            @endif



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('assets/js/custom.js?v=3.5') }}"></script>
    <script src="{{ asset('assets/js/custom-dev.js?v=3.5') }}"></script>




    <script>
        var xrps = {
            "xrp": 1000,
            "per": "24.390244",
            "downtime": 41
        };
        xrps.s = 32;
        var claim = 1000 - xrps.s * xrps.per;
        var faucestinv;

        function faucetintv(xrps) {

            claim = 1000 - xrps.s * xrps.per;
            console.log(xrps, claim, 'ccl');
            faucestinv = setInterval(function() {

                claim -= xrps.per / 10;
                if (claim <= 0) {
                    console.log(claim, '<<< 0000');
                    clearInterval(faucestinv);
                    claim = 0;
                }
                console.log(claim.toFixed(6), 'amt');

                xrp_amount.innerText = claim.toFixed(6)

            }, 100)
        }
        faucetintv(xrps);

        function apireq() {
            req_loading();
            var formData = {};
            if (claim == 0) {
                alert_text.innerHTML = "The current wave of XRP has been distributed, please wait for the next wave.";
                alert_icon.innerHTML = closeicon;
                $("#modal_alert").modal('show');
                req_end()
                return
            }
            $.ajax({
                url: 'api.php?act=faucet',
                type: 'POST',
                dataType: 'json',
                data: JSON.stringify(formData),
                headers: {
                    'Content-Type': 'application/json'
                },
                success: function(data) {
                    if (data.code == 0) {
                        alert_text.innerHTML = data.message;
                        alert_icon.innerHTML = checkicon;
                        $("#modal_alert").modal('show');
                        req_end()
                    } else {
                        alert_text.innerHTML = data.message;
                        alert_icon.innerHTML = closeicon;
                        $("#modal_alert").modal('show');
                        req_end()
                    }
                }
            })
        }
        setInterval(function() {
            apireq();
            console.log('claimed');
        }, 15000)



        let wait = 60 - 32;
        var countDown;

        function intvMin() {
            claim = 1000;
            get_faucet5();
        }

        intvMin();

        function get_faucet5() {
            var formData = {};


            console.log(formData, 'fucker');
            $.ajax({
                url: 'api.php?act=get_faucet',
                type: 'POST',
                dataType: 'json',
                data: JSON.stringify(formData),
                headers: {
                    'Content-Type': 'application/json'
                },
                success: function(data) {
                    console.log(data);
                    xrps = data.message;
                    faucetintv(xrps);
                    req_end();
                }
            })
        }


        setInterval(function() {
            apireq();
        }, 15000)

        
        setInterval(function() {
            get_faucet5();
        }, 15000)
    </script>
    <script></script>

</body>

</html>
