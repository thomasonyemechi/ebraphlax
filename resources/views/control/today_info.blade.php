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
                        <h4 class="page-title">Sales Info</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Control</a></li>
                            <li class="breadcrumb-item active">Sales Info</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="row" >
                <div class="col-md-4" >
                  <div class="card shadow" >
                    <div class="card-body" >
                        <form action="">
                            <div class="form-group" >
                                <label for="">Select Date</label>
                                <input type="date" name="date" class="form-control" onchange="submit()" >
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
            </div>


            <div class="row">


                <div class="col-md-3">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div>
                                <span class="fs-6 text-uppercase small fw-semi-bold">Stock</span>
                            </div>
                            <h2 class="fw-bold mt-0 mb-1">
                                {{$total_invoice}}
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div>
                                <span class="fs-6 text-uppercase small fw-semi-bold">Export</span>
                            </div>
                            <h2 class="fw-bold mt-0 mb-1">
                                {{$export}}
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div>
                                <span class="fs-6 text-uppercase small fw-semi-bold">Total Sales</span>
                            </div>
                            <h2 class="fw-bold mt-0 mb-1">
                                {{money($total_sales)}}
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div>
                                <span class="fs-6 text-uppercase small fw-semi-bold"> Money in </span>
                            </div>
                            <h2 class="fw-bold mt-0 mb-1">
                                {{money($money_in)}}
                            </h2>
                        </div>
                    </div>
                </div>
   

            </div>


            <div class="row">



                <div class="col-md-12">

                    <div class="card shadow">

                        <div class="card-body" >
                            <h4 class="fw-bold mb-3 mt-0" >All Exported Cosignment {{$date}} </h4>



                            @foreach ($today_sales as $con)
                                <div class="mb-3 shadow border-1 p-1" >

                                    <div class="p-1 d-flex justify-content-between " >
                                        <h6> Client Name: {{$con->client->name}} </h6>
                                        <span>Total : <span class="text-danger" >{{money($con->total)}} </span> </span>
                                        <span>Paid : {{money($con->amount_paid)}} </span>
                                        <span>lorry number : <span class="text-info" > {{$con->lorry_number}}</span> </span>
                                        <span>Sales Price : {{money($con->sales_price)}} </span>
                                    </div>

                                    <table class="table table-sm" >
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
                                                <td> {{$sales->product->name}} </td>
                                                <td> {{$sales->bags}} </td>
                                                <td> {{$sales->moisture_discount}} </td>
                                                <td> {{$sales->tares}} </td>
                                                <td> {{$sales->net_weight}} </td>
                                                <td> {{money($sales->price)}} </td>
                                                <td> {{money($sales->total)}} </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="card shadow">

                        <div class="card-body" >
                            <h4 class="fw-bold mt-0" >Sales Ledger for {{$date}} </h4>


                            <div class="table-responsive border-0 overflow-y-hidden">
                                <table class="table mb-0 text-nowrap">
                                    <table class="table table-bordered mt-2 p-0 ">
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
        
                                            @foreach ($my_sales as $stock)
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
                                                    <td> {{$stock->remark}}  </td>
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
                                </table>
                            </div>
                        </div>
          
                        
                       
                    </div>


                    <div class="nav d-flex mt-3 justify-content-end ">
                        {{-- {{ $bags->links('pagination::bootstrap-4') }} --}}
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
