@extends('layouts.app')
@section('page_title')
    Today Sales
@endsection

@section('page_content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Export Info</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Control</a></li>
                            <li class="breadcrumb-item active">Export Info</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <form action="">
                                <div class="form-group">
                                    <label for="">Select Date</label>
                                    <input type="date" name="date" class="form-control" onchange="submit()">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">



                <div class="col-md-12">

                    <div class="card shadow">

                        <div class="card-body">
                            <h4 class="fw-bold mb-3 mt-0">All Exported Cosignment {{ $date }} </h4>

                            @php
                                $total_sales = $total_profit = $total_netweight = 0;
                            @endphp

                            @foreach ($today_sales as $con)
                                @php
                                    $profit = $con->sales_price * $con->sales->sum('net_weight') - $con->total;
                                    $total_sales += $con->total;
                                    $total_profit += $profit;
                                    $total_netweight += $con->sales->sum('net_weight');
                                @endphp
                                <div class="mb-3 shadow border-1 p-1">

                                    <div class="p-1 d-flex justify-content-between ">
                                        <h6> Client Name: {{ $con->client->name }} </h6>
                                        <span>Total : <span class="text-warning">{{ money($con->total) }} </span> </span>
                                        <span>Paid : {{ money($con->amount_paid) }} </span>
                                        <span>lorry number : <span class="text-info"> {{ $con->lorry_number }}</span>
                                        </span>
                                        <span>Sales Price : {{ money($con->sales_price) }} </span>
                                        <span>Profit/Loss : <span
                                                class=" {{ $profit > 0 ? 'text-success' : 'text-danger' }} ">
                                                {{ money(abs($profit)) }} </span> </span>
                                    </div>

                                    <table class="table table-sm">
                                        <tr>
                                            <th class="text-start">Product</th>
                                            <th class="text-start">Bags</th>

                                            <th>Moisture/dis</th>
                                            <th>Tares</th>
                                            <th>Net/wt (kg)</th>

                                            <th>Price (₦)</th>
                                            <th>Ext Price</th>
                                        </tr>

                                        @foreach ($con->sales as $sales)
                                            <tr>
                                                <td> {{ $sales->product->name }} </td>
                                                <td> {{ $sales->bags }} </td>
                                                <td> {{ $sales->moisture_discount }} </td>
                                                <td> {{ $sales->tares }} </td>
                                                <td> {{ $sales->net_weight }} </td>
                                                <td> {{ money($sales->price) }} </td>
                                                <td> {{ money($sales->total) }} </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            @endforeach


                            <div class="shadow p-2" style="border: 1px solid gray;">
                                <div class="d-flex mt-1  justify-content-between ">
                                    <h6> Total Sales: <span class="text-warning" > {{ money($total_sales) }} </span> </h6>
                                    <h6> Total Net Weight: <span class="text-info" >  {{ number_format($total_netweight) }} kg </span> </h6>
                                    <h6> Total Profit: <span class=" {{ $total_profit > 0 ? 'text-success' : 'text-danger' }} " > {{ money($total_profit) }} </span> </h6>
                                </div>
                            </div>

                        </div>
                    </div>
               


                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
