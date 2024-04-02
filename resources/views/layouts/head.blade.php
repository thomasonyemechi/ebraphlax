<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <div class="logo" style="display: inline"  >
            <h4 class="fw-bold ml-3 fs-5" style="display: inline !important" > {{ env('APP_NAME') }} </h4>
        </div>
        <div class="float-right">
            <button class="button-menu-mobile ic-collapsed-btn mobile-device-arrow open-left">
                <div class="ic-medi-menu">
                    <div class="ic-bar"></div>
                    <div class="ic-bar"></div>
                    <div class="ic-bar"></div>
                </div>
            </button>
        </div>
    </div>
    <nav class="navbar-custom">
        <ul class="navbar-right d-flex list-inline float-right mb-0 align-items-center">
            <!-- sync-->
            <!-- language-->
            <!-- sync-->
            <li class="dropdown notification-list list-inline-item d-md-inline-block">
                <a class="btn btn-outline-primary ic-pos-button-header"
                    href="/control/pos">
                    <i class="mdi mdi-cart-outline"></i> Acct
                </a>
            </li>

            <li class="ms-2 mt-1">
                <a class="dropdown-item bg-light fs-4 fw-bold " href="javascript:;">
                    <span id="current_date"></span> {{ date('D, M j') }}
                </a>
            </li>

            <!-- full screen -->
            <li class="dropdown notification-list d-none d-md-block">
                <a class="nav-link" href="#" id="btn-fullscreen">
                    <i class="mdi mdi-fullscreen noti-icon"></i>
                </a>
            </li>
            <!-- Profile-->
            <li class="dropdown notification-list">
                <div class="dropdown notification-list nav-pro-img">
                    <a class="dropdown-toggle nav-link arrow-none nav-user" data-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                            <img alt="avatar" src="{{ Avatar::create(auth()->user()->name)->toBase64() }}"
                            class="rounded-circle" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                        <a href="#" class="dropdown-item">
                             {{auth()->user()->name}} <br>
                            <small> {{auth()->user()->email}} </small>
                        </a>

                        <a class="dropdown-item logout-btn" href="#">
                            <i class="mdi mdi-power text-danger"></i>
                            logout</a>

                  
                    </div>
                </div>
            </li>
        </ul>

        <ul class="list-inline menu-left mb-0 ic-left-content">
            <li class="float-left ic-larged-deviced">
                <button class="button-menu-mobile">
                    <i class="mdi mdi-arrow-right open-left ic-mobile-arrow"></i>
                    <div class="ic-medi-menu ic-humbarger-bar">
                        <div class="ic-bar"></div>
                        <div class="ic-bar"></div>
                        <div class="ic-bar"></div>
                    </div>
                </button>
            </li>
        </ul>
    </nav>
</div>




<script>
    function updateDateTime() {
        const now = new Date();
        let hour = now.getHours();
        let minute = now.getMinutes();
        document.querySelector('#current_date').textContent = `${hour}:${minute}`;
    }
    setInterval(updateDateTime, 1000);
</script>
