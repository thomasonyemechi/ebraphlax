@extends('layouts.app')
@section('page_title')
Exporters
@endsection

@section('page_content')
    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Exporters</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Customers</a></li>
                            <li class="breadcrumb-item active"> {{ $customer->name }} </li>
                        </ol>
                    </div>
                    <div class="col-sm-3 offset-3">
                        <form action="">
                            <div class="d-flex justify-content-end ">
                                <div class="input-group mr-3  ">
                                    <input type="search" name="customer" class="form-control"
                                        placeholder="Enter Customer's name and click enter"
                                        style="width: 150px !important;">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">


                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="{{ Avatar::create($customer->name)->toBase64() }}" />
                                <h2 class="fw-bold mt-2" style="font-size: 25px"> {{ $customer->name }} |
                                    {{ $customer->nick_name }} </h2>
                            </div>

                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span>Phone</span>
                                <span class="text-warning">
                                    {{ $customer->phone }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span>Email</span>
                                <span>
                                    {{ $customer->email }}
                                </span>
                            </div>
                        </div>
                    </div>


                    <div class="d-flex  justify-content-between">
                        <button class="btn btn-primary "> Update Profile </button>
                        <button class="btn btn-info "> View Ledger </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class=" fw-bold ">Account Summary </h5>
                            @if ($total_capital > 0)
                                <div class="d-flex justify-content-between border-bottom py-2">
                                    <span>Capital Given</span>
                                    <span class="text-warning">
                                        {{ money($total_capital) }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between border-bottom py-2">
                                    <span>Total Supplied</span>
                                    <span class="text-">
                                        {{ money($total_supplied) }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between border-bottom py-2">
                                    <span>Balance</span>
                                    @php
                                        $balance = customerCredit($customer->id);
                                    @endphp
                                    <span class="{{ $balance > 0 ? 'text-success' : 'text-danger' }} ">
                                        {{ $balance > 0 ? 'To Supply' : 'owing' }}
                                        <br>
                                        {{ money($balance) }}
                                    </span>
                                </div>
                            @else
                                <div class="d-flex justify-content-between border-bottom py-2">
                                    <span>Total Supplied</span>
                                    <span class="text-">
                                        {{ money($total_supplied) }}
                                    </span>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span>Net Weight</span>
                                <span>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span>Total Expense</span>
                                <span>
                                </span>
                            </div>
                            {{-- <div class="d-flex justify-content-between border-bottom py-2">
                                <span>Biggest Purchase</span>
                                <span>
                                    {{ money(2459000) }}
                                    <br>
                                    {{ date('Y M D') }}
                                </span>
                            </div> --}}

                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex  justify-content-between ">
                                <h5 class=" fw-bold ">Manage Capital</h5>
                                <a href="javascript:;" class="btn btn-secondary add_capital pt-2 btn-sm">add Capital</a>
                            </div>



                            <div>
                                <table class="table table-sm mt-2 p-0 ">
                                    <thead>
                                        <tr>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>added by</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($capitals as $capital)
                                            <tr>
                                                <td>{{ money($capital->amount) }}</td>
                                                <td>
                                                    <div class="badge py-1 badge-success">
                                                        {{ $capital->status }}
                                                    </div>
                                                </td>
                                                <td>{{ $capital->user->name }}</td>
                                                <td>
                                                    <a href="/control/delete_capital/{{ $capital->id }}"
                                                        class="text-danger"
                                                        onclick="return confirm('Capital will be removed from this account and will be accounted for')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex  justify-content-between ">
                                <h5 class="fw-bold">Ledger</h5>
                                <a href="/control/customer/ledger/{{ $customer->id }}">See Customer Ledger</a>
                            </div>
                            <table class="table table-bordered mt-2 p-0 ">
                                <thead>
                                    <tr>
                                        <th class="align-middle">Date</th>
                                        <th class="align-middle">Commodity</th>
                                        <th class="align-middle">Bags</th>

                                        <th class="align-middle">Gross <br>/wt (kg)</th>
                                        <th class="align-middle">Tares</th>
                                        <th class="align-middle">Moisture <br>/dis</th>

                                        <th class="align-middle">Net<br>/wt (kg)</th>

                                        <th class="align-middle">Price (₦)</th>
                                        <th class="align-middle">Ext Price</th>
                                        <th class="align-middle">Ammount Paid</th>
                                        <th class="align-middle">Credit /Debit</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($stocks as $stock)
                                        @php
                                            $amount_paid = getAmmountPaid($stock->summary_id);
                                        @endphp
                                        <tr>
                                            <td> {{ $stock->created_at }} </td>
                                            <td> {{ $stock->product->name }} </td>
                                            <td> {{ number_format(abs($stock->bags)) }} </td>
                                            <td> {{ number_format(abs($stock->gross_weight)) }} </td>

                                            <td> {{ abs($stock->bags * 1.5) }} </td>
                                            <td> {{ number_format(abs($stock->moisture_discount)) }} </td>
                                            <td> {{ number_format(abs($stock->net_weight)) }} </td>
                                            <td> {{ money($stock->price) }} </td>
                                            <td> {{ money($stock->total) }} </td>
                                            <td> {{ money($amount_paid) }} </td>
                                            <td> {{ money($stock->current_balance - $stock->total) }} </td>
                                            <td> {{ money($amount_paid - $stock->total) }} </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="nav d-flex mt-3 justify-content-end ">
                        {{ $stocks->links('pagination::bootstrap-4') }}
                    </div>




                </div>



            </div>
        </div>
    </div>


    <div class="modal fade" id="add_capital" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title m-0" id="exampleModalLongTitle"> Add Capital </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form method="POST" class="row" action="/control/add_capital">
                        @csrf
                        <div class="col-lg-12 mb-2 ">
                            <label class="form-label">Capital Amount<span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="amount">
                            <input type="hidden" name="action" value="export">
                            <input type="hidden" name="user_id" value="{{ $customer->id }}">


                            <div class="d-flex mt-3 justify-content-end">
                                <button type="submit" class="btn py-2 btn-primary">Add Capital</button>
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
            $('.add_capital').on('click', function() {
                $('#add_capital').modal('show')
            })
        })
    </script>
@endpush
