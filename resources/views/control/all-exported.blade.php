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
                                            <button class="btn btn-info btn-sm enter_summary mr-2"
                                                data-data="{{ json_encode($con) }}">Edit Cosignment
                                                Summary</button>
                                            <span class="badge mr-1 bg-warning">Gross Weight :
                                                {{ number_format($con->gross_weight, 1) }} </span>
                                            <span class="badge mr-1 bg-info">Net Weight :
                                                {{ number_format($con->net_weight, 1) }} </span>
                                            <span class="badge mr-1 bg-success">Tares : {{ number_format($con->tares, 1) }}
                                            </span>
                                            <span class="badge mr-1 bg-danger">Moisture Dis :
                                                {{ number_format($con->moisture_discount, 1) }}
                                            </span>
                                        </div>
                                        <div class="p-1 d-flex justify-content-between ">

                                            <h6> Client Name: {{ $con->client->name }} </h6>
                                            </span>
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
                                                <th >
                                                    <div class="d-flex justify-content-end" >Ext Price </div> </th>
                                            </tr>
                                            @php
                                                $total_bags = $total_net_weight = $total_price = 0;
                                            @endphp
                                            @foreach ($con->sales as $sales)
                                            @php
                                                $total_bags += $sales->bags;
                                                $total_price += $sales->total;
                                                $total_net_weight += $sales->net_weight;
                                            @endphp
                                                <tr>
                                                    <td> {{ $sales->product->name }} </td>
                                                    <td> {{ $sales->bags }} </td>
                                                    <td> {{ $sales->moisture_discount }} </td>
                                                    <td> {{ $sales->tares }} </td>
                                                    <td> {{ $sales->net_weight }} </td>
                                                    <td> {{ money($sales->price) }} </td>
                                                    <td >
                                                            <div class="d-flex justify-content-end" >
                                                                {{ money($sales->total) }}
                                                            </div>
                                                 </td>
                                                </tr>
                                            @endforeach

                                            <tr>
                                                <th></th>
                                                <th > {{ $total_bags }} bags </th>
                                                <th></th>
                                                <th></th>
                                                <th> {{number_format($total_net_weight,1)}} kg </th>
                                                <th></th>
                                                <th>
                                                    <div class="d-flex justify-content-end" >
                                                  <span class="fw-bold text-warning " >
                                                    {{ money($total_price) }}
                                                  </span>
                                                    </div>
                                                </th>

                                            </tr>
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


    <div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title m-0" id="exampleModalLongTitle">Enter Cosignment Sumary </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form method="POST" class="row" action="/control/enter_sumary">
                        @csrf


                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label ">Gross Weight<span class="required">*</span></label>
                                <input type="text" name="gross_weight" class="form-control">
                                <input type="hidden" name="summary_id" class="form-control">
                                @error('gross_weight')
                                    <i class="text-danger small"> {{ $message }} </i>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label ">Net Weight<span class="required">*</span></label>
                                <input type="text" name="net_weight" class="form-control">
                                @error('net_weight')
                                    <i class="text-danger small"> {{ $message }} </i>
                                @enderror
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Tares <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" step="any" name="tares">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Bags <span class="text-danger">*</span> </label>
                                <input type="number" step="any" class="form-control" name="bags">
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Mositure Discount <span class="text-danger">*</span></label>
                                <input type="number" step="any" class="form-control" name="moisture_discount">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="d-flex mt-3 justify-content-end">
                                <button type="submit" class="btn py-2 btn-primary">Submit Summary </button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(function() {
            $('body').on('click', '.enter_summary', function() {
                data = $(this).data('data');
                console.log(data);
                modal = $('#inputModal');
                modal.modal('show');

                modal.find('input[name="summary_id"]').val(data.id);
                modal.find('input[name="gross_weight"]').val(data.gross_weight);
                modal.find('input[name="net_weight"]').val(data.net_weight);
                modal.find('input[name="tares"]').val(data.tares);
                modal.find('input[name="bags"]').val(data.bags);
                modal.find('input[name="moisture_discount"]').val(data.moisture_discount);
            })
        })
    </script>
@endpush
