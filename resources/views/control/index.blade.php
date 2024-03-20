@extends('layouts.app')
@section('page_title')
    Admin Overview
@endsection

@section('page_content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Chartist  -->
    <link rel="stylesheet"
        href="https://clanvent-alpha.laravel-script.com/public/admin/plugins/chartist/css/chartist.min.css">

    <!-- Custom css  -->
    <link rel="stylesheet" href="https://clanvent-alpha.laravel-script.com/public/admin/css/custom.css">
    <style>
        :root {
            /*#28aaa9*/
            --primary-color: #000000;
            /*#2b2d5d*/
            --secondary-color: #000000;
        }
    </style>



    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Dashboard</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Welcome {{ auth()->user()->name }} </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="ic-section-gap">
                <div class="row">
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a href="/control/customers">
                            <div class="ic-card-head primary"><i class="flaticon-conversation ic-card-icon"></i> <i
                                    class="flaticon-conversation big-icon"></i>
                                <h3>{{ $total_customer }}</h3>
                                <p>Total Customer</p>
                            </div>
                        </a></div>
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a href="/control/supplier/all">
                            <div class="ic-card-head secondary"><i class="flaticon-inventory ic-card-icon"></i> <i
                                    class="flaticon-inventory big-icon"></i>
                                <h3>{{ $total_supplier }}</h3>
                                <p>Total Supplier</p>
                            </div>
                        </a></div>
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a href="/control/products">
                            <div class="ic-card-head info"><i class="flaticon-new-product ic-card-icon"></i> <i
                                    class="flaticon-new-product big-icon"></i>
                                <h3>{{ $total_product }}</h3>
                                <p>Total Product</p>
                            </div>
                        </a></div>
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a href="/control/exports">
                            <div class="ic-card-head success"><i class="flaticon-shopping-bag ic-card-icon"></i> <i
                                    class="flaticon-shopping-bag big-icon"></i>
                                <h3>{{ $total_sales }}</h3>
                                <p>Total Sale</p>
                            </div>
                        </a></div>
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a href="/control/imports">
                            <div class="ic-card-head"><i class="flaticon-shopping-bag-1 ic-card-icon"
                                    style="background-color: rgb(6, 68, 32);"></i> <i
                                    class="flaticon-shopping-bag-1 big-icon"></i>
                                <h3>{{ $total_import }}</h3>
                                <p>Total Imports</p>
                            </div>
                        </a></div>
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a href="/control/expense_overview">
                            <div class="ic-card-head warning"><i class="flaticon-expenses ic-card-icon"></i> <i
                                    class="flaticon-expenses big-icon"></i>
                                <h3>{{ $total_expenses }}</h3>
                                <p>Total Expenses</p>
                            </div>
                        </a></div>
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a href="/control/invoices">
                            <div class="ic-card-head success"><i class="flaticon-shopping-bag ic-card-icon"></i> <i
                                    class="flaticon-shopping-bag big-icon"></i>
                                <h3> {{ money($sales_amount) }} </h3>
                                <p>Sale Amount</p>
                            </div>
                        </a></div>
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a href="/control/purchases">
                            <div class="ic-card-head primary"><i class="flaticon-shopping-bag-1 ic-card-icon"></i> <i
                                    class="flaticon-shopping-bag-1 big-icon"></i>
                                <h3>$ </h3>
                                <p>Purchase Amount</p>
                            </div>
                        </a></div>
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a href="/control/expenses">
                            <div class="ic-card-head danger"><i class="flaticon-expenses ic-card-icon"></i> <i
                                    class="flaticon-expenses big-icon"></i>
                                <h3> {{ money($expenses_amount) }} </h3>
                                <p>Expenses Amount</p>
                            </div>
                        </a></div>


                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a href="/control/products">
                            <div class="ic-card-head"><i class="flaticon-report ic-card-icon"
                                    style="background-color: rgb(91, 91, 37);"></i> <i class="flaticon-report big-icon"></i>
                                <h3>{{ $total_stock }}</h3>
                                <p>Total Stock</p>
                            </div>
                        </a></div>
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a
                            href="/control/sales/{{ auth()->user()->id }}">
                            <div class="ic-card-head"><i class="flaticon-shopping-bag-1 ic-card-icon"
                                    style="background-color: rgb(80, 53, 112);"></i> <i
                                    class="flaticon-shopping-bag-1 big-icon"></i>
                                <h3>{{ $invoice_by_you }}</h3>
                                <p>Total Invoice By You</p>
                            </div>
                        </a></div>
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a href="/control/invoices">
                            <div class="ic-card-head"><i class="flaticon-shopping-bag ic-card-icon"
                                    style="background-color: rgb(112, 53, 76);"></i> <i
                                    class="flaticon-shopping-bag big-icon"></i>
                                <h3 class="sss" > {{ money($sales_by_you) }} </h3>
                                <p>Total Sale By You</p>
                            </div>
                        </a></div>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-item-center">
                                <div class="col-lg-12 ic-expance-text-heading-part">
                                    <h4 class="ic-expance-heading">Sales This Year </h4>
                                    <h3 class="ic-earning-heading">$ 5493536.00</h3>
                                </div>
                                <div class="col-lg-8 my-auto ic-expance-form-heads">
                                    <form action="">
                                        <div class="row input-daterange ic-mobile-range">
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group mb-lg-0"><input type="text" name="from_date"
                                                        value="" id="from_date" placeholder="From Date"
                                                        autocomplete="off" required="required" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group mb-lg-0"><input type="text" name="to_date"
                                                        value="" id="to_date" placeholder="To Date"
                                                        autocomplete="off" required="required" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3 col-12"><button type="submit"
                                                    class="btn btn-primary btn-block"><i class="mdi mdi-filter"></i>
                                                    Filter</button></div>
                                            <div class="col-md-6 col-lg-3 col-12"><a href="/control/dashboard"
                                                    class="btn btn-primary btn-block mt-3 mt-md-0"><i
                                                        class="mdi mdi-refresh"></i> Refresh</a></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-4 my-auto ic-expance-form-chart input-daterange ic-mobile-range"><button
                                        type="button" id="line" class="btn btn-secondary"><i
                                            class="fas fa-chart-line"></i>
                                        Line</button> <button type="button" id="bar" class="btn btn-secondary"><i
                                            class="fas fa-chart-bar"></i>
                                        Bar</button></div>
                            </div> <canvas id="salesChart" height="213" width="641"
                                style="display: block; box-sizing: border-box; height: 213px; width: 641px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-4">
                    <div class="card ic-max-height-same">
                        <div class="card-body">
                            <div class="ic-expance-part">
                                <div class="ic-expance-text">
                                    <h4 class="ic-expance-heading">Sales All Time</h4>
                                    <h3 class="ic-earning-heading">$ 5493536.00</h3>
                                </div>
                            </div>
                            <div class="ic-piechart-part"><canvas id="pieChart" width="250" height="250"
                                    style="display: block; box-sizing: border-box; height: 250px; width: 250px;"></canvas>
                                <ul>
                                    <li><span class="this-mounth"><span class="circle-this"></span> This Month
                                            $ 151551.00</span></li>
                                    <li><span class="last-mounth"><span class="circle-last"></span> Last Month
                                            $ 5304562.00</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ic_products_heads">
                <div class="row">
                    <div class="col-xl-6 col-lg-12">
                        <div class="card ic-card-height-same">
                            <div class="card-body">
                                <div
                                    class="ic-top-products-heading page-title-box pt-0 d-flex align-items-center justify-content-between">
                                    <h4 class="page-sub-title">Top Product</h4>
                                    <div class="float-right d-none d-md-block">
                                        <div class="dropdown"><button type="button" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false" id="btn_ddl"
                                                class="btn btn-muted dropdown-toggle arrow-none waves-effect waves-light">
                                                Month <i class="fas fa-chevron-down ml-2"></i></button>
                                            <div class="dropdown-menu dropdown-menu-right"><a id="year_2024"
                                                    href="#"
                                                    class="dropdown-item ic-getTop-sale-products prevent-default">
                                                    Year</a> <a id="month_2024-03" href="#"
                                                    class="dropdown-item ic-getTop-sale-products prevent-default">
                                                    Month</a> <a id="week_2024-03-03" href="#"
                                                    class="dropdown-item ic-getTop-sale-products prevent-default">
                                                    Week</a></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-slider-heads">
                                    <div class="ic-products-card border">
                                        <div class="ic-products-images">
                                            <img src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                class="img-fluid" alt="Lenovo IdeaPad Slim 3 Ryzen">
                                        </div>
                                        <div class="ic-product-content">
                                            <h6>Lenovo IdeaPad Slim 3 Ryzen</h6>
                                            <p class="mb-0">$ 16100.00</p>
                                        </div>
                                    </div>

                                    <div class="ic-products-card border">
                                        <div class="ic-products-images">
                                            <img src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                class="img-fluid" alt="Apple MacBook Air">
                                        </div>
                                        <div class="ic-product-content">
                                            <h6>Apple MacBook Air</h6>
                                            <p class="mb-0">$ 51320.00</p>
                                        </div>
                                    </div>

                                    <div class="ic-products-card border">
                                        <div class="ic-products-images">
                                            <img src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                class="img-fluid" alt="Apple MacBook Air 13.3-Inch">
                                        </div>
                                        <div class="ic-product-content">
                                            <h6>Apple MacBook Air 13.3-Inch</h6>
                                            <p class="mb-0">$ 48000.00</p>
                                        </div>
                                    </div>

                                    <div class="ic-products-card border">
                                        <div class="ic-products-images">
                                            <img src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                class="img-fluid" alt="iPhone 13 Pro">
                                        </div>
                                        <div class="ic-product-content">
                                            <h6>iPhone 13 Pro</h6>
                                            <p class="mb-0">$ 35100.00</p>
                                        </div>
                                    </div>

                                    <div class="ic-products-card border">
                                        <div class="ic-products-images">
                                            <img src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                class="img-fluid" alt="iPhone 13">
                                        </div>
                                        <div class="ic-product-content">
                                            <h6>iPhone 13</h6>
                                            <p class="mb-0">$ 42000.00</p>
                                        </div>
                                    </div>

                                    <div class="ic-products-card border">
                                        <div class="ic-products-images">
                                            <img src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                class="img-fluid" alt="Polo shirt">
                                        </div>
                                        <div class="ic-product-content">
                                            <h6>Polo shirt</h6>
                                            <p class="mb-0">$ 5151160.00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div
                                    class="ic-top-products-heading page-title-box pt-0 d-flex align-items-center justify-content-between">
                                    <h4 class="page-sub-title">Best Item All Time</h4>
                                    <div class="float-right d-none d-md-block">
                                        <div class="dropdown"><a href="/control/products"
                                                class="btn btn-secondary2 dropdown-toggle arrow-none waves-effect waves-light">
                                                View All
                                            </a></div>
                                    </div>
                                </div>
                                <div class="ic-best-products-items slick-initialized slick-slider slick-vertical">
                                    <div class="slick-list draggable" style="height: 324px;">
                                        <div class="slick-track"
                                            style="opacity: 1; height: 1404px; transform: translate3d(0px, -432px, 0px);">
                                            <div class="media d-flex slick-slide slick-cloned" data-slick-index="-3"
                                                id="" aria-hidden="true" style="width: 460px;" tabindex="-1">
                                                <div class="ic-best-products-images"><img
                                                        src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                        alt="product-image" class="img-fluid inline-block"></div>
                                                <div class="media-body">
                                                    <h6><a href="/control/products/46/edit" tabindex="-1">Edifier G20
                                                            7.1</a></h6>
                                                    <p>Total Sale : <span>$ 25450.00</span></p>
                                                </div>
                                            </div>
                                            <div class="media d-flex slick-slide slick-cloned" data-slick-index="-2"
                                                id="" aria-hidden="true" style="width: 460px;" tabindex="-1">
                                                <div class="ic-best-products-images"><img
                                                        src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                        alt="product-image" class="img-fluid inline-block"></div>
                                                <div class="media-body">
                                                    <h6><a href="/control/products/50/edit" tabindex="-1">Polo shirt</a>
                                                    </h6>
                                                    <p>Total Sale : <span>$ 5151160.00</span></p>
                                                </div>
                                            </div>
                                            <div class="media d-flex slick-slide slick-cloned" data-slick-index="-1"
                                                id="" aria-hidden="true" style="width: 460px;" tabindex="-1">
                                                <div class="ic-best-products-images"><img
                                                        src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                        alt="product-image" class="img-fluid inline-block"></div>
                                                <div class="media-body">
                                                    <h6><a href="/control/products/52/edit" tabindex="-1">Zara Man
                                                            Shirt</a></h6>
                                                    <p>Total Sale : <span>$ 110592.00</span></p>
                                                </div>
                                            </div>
                                            <div class="media d-flex slick-slide" data-slick-index="0" aria-hidden="true"
                                                style="width: 460px;" tabindex="-1">
                                                <div class="ic-best-products-images"><img
                                                        src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                        alt="product-image" class="img-fluid inline-block"></div>
                                                <div class="media-body">
                                                    <h6><a href="/control/products/42/edit" tabindex="-1">Apple MacBook
                                                            Air</a></h6>
                                                    <p>Total Sale : <span>$ 51320.00</span></p>
                                                </div>
                                            </div>
                                            <div class="media d-flex slick-slide slick-current slick-active"
                                                data-slick-index="1" aria-hidden="false" style="width: 460px;"
                                                tabindex="0">
                                                <div class="ic-best-products-images"><img
                                                        src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                        alt="product-image" class="img-fluid inline-block"></div>
                                                <div class="media-body">
                                                    <h6><a href="/control/products/45/edit" tabindex="0">Razer Level Up
                                                            Bundle</a></h6>
                                                    <p>Total Sale : <span>$ 10150.00</span></p>
                                                </div>
                                            </div>
                                            <div class="media d-flex slick-slide slick-active" data-slick-index="2"
                                                aria-hidden="false" style="width: 460px;" tabindex="0">
                                                <div class="ic-best-products-images"><img
                                                        src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                        alt="product-image" class="img-fluid inline-block"></div>
                                                <div class="media-body">
                                                    <h6><a href="/control/products/46/edit" tabindex="0">Edifier G20
                                                            7.1</a></h6>
                                                    <p>Total Sale : <span>$ 25450.00</span></p>
                                                </div>
                                            </div>
                                            <div class="media d-flex slick-slide slick-active" data-slick-index="3"
                                                aria-hidden="false" style="width: 460px;" tabindex="0">
                                                <div class="ic-best-products-images"><img
                                                        src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                        alt="product-image" class="img-fluid inline-block"></div>
                                                <div class="media-body">
                                                    <h6><a href="/control/products/50/edit" tabindex="0">Polo shirt</a>
                                                    </h6>
                                                    <p>Total Sale : <span>$ 5151160.00</span></p>
                                                </div>
                                            </div>
                                            <div class="media d-flex slick-slide" data-slick-index="4" aria-hidden="true"
                                                style="width: 460px;" tabindex="-1">
                                                <div class="ic-best-products-images"><img
                                                        src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                        alt="product-image" class="img-fluid inline-block"></div>
                                                <div class="media-body">
                                                    <h6><a href="/control/products/52/edit" tabindex="-1">Zara Man
                                                            Shirt</a></h6>
                                                    <p>Total Sale : <span>$ 110592.00</span></p>
                                                </div>
                                            </div>
                                            <div class="media d-flex slick-slide slick-cloned" data-slick-index="5"
                                                id="" aria-hidden="true" style="width: 460px;" tabindex="-1">
                                                <div class="ic-best-products-images"><img
                                                        src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                        alt="product-image" class="img-fluid inline-block"></div>
                                                <div class="media-body">
                                                    <h6><a href="/control/products/42/edit" tabindex="-1">Apple MacBook
                                                            Air</a></h6>
                                                    <p>Total Sale : <span>$ 51320.00</span></p>
                                                </div>
                                            </div>
                                            <div class="media d-flex slick-slide slick-cloned" data-slick-index="6"
                                                id="" aria-hidden="true" style="width: 460px;" tabindex="-1">
                                                <div class="ic-best-products-images"><img
                                                        src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                        alt="product-image" class="img-fluid inline-block"></div>
                                                <div class="media-body">
                                                    <h6><a href="/control/products/45/edit" tabindex="-1">Razer Level Up
                                                            Bundle</a></h6>
                                                    <p>Total Sale : <span>$ 10150.00</span></p>
                                                </div>
                                            </div>
                                            <div class="media d-flex slick-slide slick-cloned" data-slick-index="7"
                                                id="" aria-hidden="true" style="width: 460px;" tabindex="-1">
                                                <div class="ic-best-products-images"><img
                                                        src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                        alt="product-image" class="img-fluid inline-block"></div>
                                                <div class="media-body">
                                                    <h6><a href="/control/products/46/edit" tabindex="-1">Edifier G20
                                                            7.1</a></h6>
                                                    <p>Total Sale : <span>$ 25450.00</span></p>
                                                </div>
                                            </div>
                                            <div class="media d-flex slick-slide slick-cloned" data-slick-index="8"
                                                id="" aria-hidden="true" style="width: 460px;" tabindex="-1">
                                                <div class="ic-best-products-images"><img
                                                        src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                        alt="product-image" class="img-fluid inline-block"></div>
                                                <div class="media-body">
                                                    <h6><a href="/control/products/50/edit" tabindex="-1">Polo shirt</a>
                                                    </h6>
                                                    <p>Total Sale : <span>$ 5151160.00</span></p>
                                                </div>
                                            </div>
                                            <div class="media d-flex slick-slide slick-cloned" data-slick-index="9"
                                                id="" aria-hidden="true" style="width: 460px;" tabindex="-1">
                                                <div class="ic-best-products-images"><img
                                                        src="https://clanvent-alpha.laravel-script.com/public/images/default.png"
                                                        alt="product-image" class="img-fluid inline-block"></div>
                                                <div class="media-body">
                                                    <h6><a href="/control/products/52/edit" tabindex="-1">Zara Man
                                                            Shirt</a></h6>
                                                    <p>Total Sale : <span>$ 110592.00</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ic-products-table">
                <div class="card">
                    <div class="card-body"><label for="">Latest Sales</label>
                        <div class="table-responsive">
                            <table id="table_id" class="datatable table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Invoice ID</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Paid</th>
                                        <th>Paid By</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><a href="/control/invoices/76">00000076</a>
                                        </td>
                                        <td>2024-03-03</td>
                                        <td>
                                            Demo Customer
                                        </td>
                                        <td>$ 1712.00</td>
                                        <td>$ 0.00</td>
                                        <td>ONLINE</td>
                                        <td><span class="badge badge-warning">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><a href="/control/invoices/75">00000075</a>
                                        </td>
                                        <td>2024-03-03</td>
                                        <td>
                                            Walk-In Customer
                                        </td>
                                        <td>$ 1.00</td>
                                        <td>$ 0.00</td>
                                        <td>ONLINE</td>
                                        <td><span class="badge badge-warning">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><a href="/control/invoices/74">00000074</a>
                                        </td>
                                        <td>2024-03-02</td>
                                        <td>
                                            Walk-In Customer
                                        </td>
                                        <td>$ 3424.00</td>
                                        <td>$ 0.00</td>
                                        <td>CASH</td>
                                        <td><span class="badge badge-warning">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td><a href="/control/invoices/73">00000073</a>
                                        </td>
                                        <td>2024-03-02</td>
                                        <td>
                                            Walk-In Customer
                                        </td>
                                        <td>$ 3424.00</td>
                                        <td>$ 0.00</td>
                                        <td>CASH</td>
                                        <td><span class="badge badge-warning">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td><a href="/control/invoices/72">00000072</a>
                                        </td>
                                        <td>2024-03-02</td>
                                        <td>
                                            Demo Customer
                                        </td>
                                        <td>$ 129154.00</td>
                                        <td>$ 0.00</td>
                                        <td>CASH</td>
                                        <td><span class="badge badge-warning">Pending</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')


<script type="text/javascript">
    !(function ($) {
        "use strict";


        // line Chart
        const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const data = {
            labels: labels,
            datasets: [{
                label: 'Sales($ )',
                backgroundColor: '#FF5733',
                borderColor: '#FF5733',
                data: [0,"5304562.00","151551.00",0,0,0,0,0,0,0,0,0],
            }]
        };

        // init config
        const config = {
            type: 'line',
            data,
            options: {}
        };

        var myChart;

        icChange('line');
        $("#line").on('click', function () {
            icChange('line');
        });

        $("#bar").on('click', function () {
            icChange('bar');
        });

        function icChange(newType) {
            var ctx = document.getElementById("salesChart").getContext("2d");

            if (myChart) {
                myChart.destroy();
            }

            var temp = jQuery.extend(true, {}, config);
            temp.type = newType;
            myChart = new Chart(ctx, temp);
        };

        // pie chart
        var oilCanvas = document.getElementById("pieChart");
        var oilData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [
                {
                    data: [0,"5304562.00","151551.00",0,0,0,0,0,0,0,0,"37423.00"],
                    backgroundColor: [
                        "#FF6384",
                        "#63FF84",
                        "#6FE3D5",
                        "#5182FF",
                        "#56C876",
                        "#2A73A8",
                        "#EEBF48",
                        "#6FE3C0",
                        "#28AAA9",
                        "#6FE3C0",
                        "#3D96FF",
                        "#E36F6F"
                    ]
                }]
        };

        var pieChart = new Chart(oilCanvas, {
            type: 'pie',
            data: oilData,
            options: {
                responsive: true,
                legend: {
                    display: true,
                    position: 'bottom'
                },
            },
        });

    })(jQuery);
</script>

@endpush
