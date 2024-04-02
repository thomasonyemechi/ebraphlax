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


        h3 {
            font-size: 15px;
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
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a href="javascript:;">
                            <div class="ic-card-head success"><i class="flaticon-shopping-bag ic-card-icon"></i> <i
                                    class="flaticon-shopping-bag big-icon"></i>
                                <h3>{{ $total_sales }}</h3>
                                <p>Total Sale</p>
                            </div>
                        </a></div>
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a href="javascript:;">
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
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a href="javascript:;">
                            <div class="ic-card-head success"><i class="flaticon-shopping-bag ic-card-icon"></i> <i
                                    class="flaticon-shopping-bag big-icon"></i>
                                <h3> {{ money($sales_amount) }} </h3>
                                <p>Sale Amount</p>
                            </div>
                        </a></div>
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a href="javascript:;">
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
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a>
                            <div class="ic-card-head"><i class="flaticon-shopping-bag-1 ic-card-icon"
                                    style="background-color: rgb(80, 53, 112);"></i> <i
                                    class="flaticon-shopping-bag-1 big-icon"></i>
                                <h3>{{ $invoice_by_you }}</h3>
                                <p>Total Invoice By You</p>
                            </div>
                        </a></div>
                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-6"><a >
                            <div class="ic-card-head"><i class="flaticon-shopping-bag ic-card-icon"
                                    style="background-color: rgb(112, 53, 76);"></i> <i
                                    class="flaticon-shopping-bag big-icon"></i>
                                <h3 class="sss" style="font-size: 15px" > {{ money($sales_by_you) }} </h3>
                                <p>Total Sale By You</p>
                            </div>
                        </a></div>

                </div>
            </div>


            <div class="ic-products-table">
                <div class="card">
                    <div class="card-body"><label for="">Latest Sales</label>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mt-2 p-0 ">
                                <thead>
                                    <tr>
                                        <th class="align-middle">Date</th>
                                        <th class="align-middle">Action</th>
                                        <th class="align-middle">Client</th>
                                        <th class="align-middle">Commodity</th>
                                        <th class="align-middle">Bags</th>

                                        <th class="align-middle">Gross <br>/wt (kg)</th>
                                        <th class="align-middle">Tares</th>
                                        <th class="align-middle">Moisture <br>/dis</th>

                                        <th class="align-middle">Net<br>/wt (kg)</th>

                                        <th class="align-middle">Price (₦)</th>
                                        <th class="align-middle">Ext Price</th>
                                        <th class="align-middle">Ammount Paid</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($stocks as $stock)
                                        @php
                                            $amount_paid = getAmmountPaid($stock->summary_id);
                                        @endphp
                                        @if ($stock->action == 'export' || $stock->action == 'import')
                                            <tr>
                                                <td> {{ $stock->created_at }} </td>
                                                <td> {{ $stock->action }} </td>
                                                <td> {{ $stock->client->name }} </td>
                                                <td> {{ $stock->product->name }} </td>
                                                <td> {{ number_format(abs($stock->bags)) }} </td>
                                                <td> {{ number_format(abs($stock->gross_weight)) }} </td>

                                                <td> {{ abs($stock->bags * 1.5) }} </td>
                                                <td> {{ number_format(abs($stock->moisture_discount)) }} </td>
                                                <td> {{ number_format(abs($stock->net_weight)) }} </td>
                                                <td> {{ money($stock->price) }} </td>
                                                <td> {{ money($stock->total) }} </td>
                                                <td> {{ money($stock->amount_paid) }} </td>

                                            </tr>
                                        @elseif($stock->action == 'capital' || $stock->action == 'expenses')
                                            <tr>
                                                <td> {{ $stock->created_at }} </td>
                                                <td> {{ $stock->action }} </td>
                                                <td> {{ $stock->client->name }} </td>
                                                <td> {{ $stock->remark }} </td>
                                                <td> - </td>
                                                <td> - </td>
                                                <td> - </td>
                                                <td> - </td>
                                                <td> - </td>
                                                <td> - </td>
                                                <td> - </td>

                                                <td> {{ money($stock->total) }} </td>

                                            </tr>
                                        @endif
                                    @endforeach

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
        !(function($) {
            "use strict";


            // line Chart
            const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                'October', 'November', 'December'
            ];
            const data = {
                labels: labels,
                datasets: [{
                    label: 'Sales($ )',
                    backgroundColor: '#FF5733',
                    borderColor: '#FF5733',
                    data: [0, "5304562.00", "151551.00", 0, 0, 0, 0, 0, 0, 0, 0, 0],
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
            $("#line").on('click', function() {
                icChange('line');
            });

            $("#bar").on('click', function() {
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
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                    'October', 'November', 'December'
                ],
                datasets: [{
                    data: [0, "5304562.00", "151551.00", 0, 0, 0, 0, 0, 0, 0, 0, "37423.00"],
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
