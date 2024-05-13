@extends('layouts.app')
@section('page_title')
    Exported
@endsection

@section('page_content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">All Export</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Control</a></li>
                            <li class="breadcrumb-item active">Export Consignent</li>
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
                            <h4 class="fw-bold mb-3 mt-0">All Exported Cosignment </h4>

                            @php
                                $total_sales = $total_profit = $total_netweight = 0;
                            @endphp

                            @foreach ($exports as $con)
                                @if (count($con->sales) > 0)
                                    @php
                                        $profit = $con->sales_price * $con->sales->sum('net_weight') - $con->total;
                                        $total_sales += $con->total;
                                        $total_profit += $profit;
                                        $total_netweight += $con->sales->sum('net_weight');
                                    @endphp
                                    <div class="mb-3 shadow border-1 p-1" style="border: 1px solid black">

                                        <div class="d-flex m-1">
                                            <button class="btn btn-info btn-sm mr-2" >Input Summary</button>
                                        </div>
                                        <div class="p-1 d-flex justify-content-between ">
                                          
                                            <h6> Client Name: {{ $con->client->name }} </h6>
                                            <span>Total : <span class="text-warning">{{ money($con->total) }} </span>
                                            </span>
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
                                @endif
                            @endforeach



                        </div>
                    </div>


                    <div>
                        {{ $exports->links('pagination::bootstrap-4') }}
                    </div>



                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
