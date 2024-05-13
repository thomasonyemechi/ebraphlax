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


                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="{{ Avatar::create($customer->name)->toBase64() }}" />
                                <h2 class="fw-bold mt-2" style="font-size: 25px"> {{ $customer->name }} |
                                    {{ $customer->nick_name }} </h2>
                                    <p class="mb-0"> {{ $customer->address ?? 'No address' }} </p>

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
                        <button class="btn btn-primary editProffile "> Update Profile </button>
                        <a href="/control/customer/ledger/{{ $customer->id }}" target="_blank" class="btn btn-info  "> Print
                            Ledger </a>
                    </div>
                </div>
                <div class="col-md-6">
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

                <div class="col-md-6">
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="d-flex  justify-content-between ">
                                <h5 class=" fw-bold ">Manage Capital</h5>
                                <a href="javascript:;" class="btn btn-secondary add_capital py-2 btn-sm">add Capital</a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm mt-2 p-0 ">
                                    <thead>
                                        <tr>
                                            <th>Amount</th>
                                            <th>Type</th>
                                            <th>Vocher <br> Number </th>
                                            <th>Date</th>
                                            <th>added by</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>



                                        @foreach ($capitals as $capital)
                                            <tr>
                                                <td>{{ money($capital->total) }}</td>
                                                <td>{{ $capital->type }}</td>
                                                <td>{{ $capital->vocher_number }}</td>

                                                <td>
                                                    <div class="badge py-1 badge-success">
                                                        {{ date('j M, Y', strtotime($capital->created_at)) }}
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
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="d-flex  justify-content-between ">
                                <h5 class="fw-bold">Ledger</h5>
                                {{-- <a href="/control/customer/ledger/{{ $customer->id }}">See Customer Ledger</a> --}}
                            </div>
                            <div class="table-responsive">
                                @include('control.ledger')
                            </div>
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
                         
                            <input type="hidden" name="action" value="export">
                            <input type="hidden" name="user_id" value="{{ $customer->id }}">


                            <div class="row" >
                                <div class="col-md-6" >
                                    <label class="form-label">Capital Amount<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="amount">
                                </div>
                                <div class="col-md-6" >
                                    <label class="form-label">Type<span class="text-danger">*</span></label>
                                    <select name="type" class="form-control" id="">
                                        <option>Cash</option>
                                        <option>Transfer</option>
                                        <option>Cheque</option>
                                    </select>
                                </div>
                            </div>

                            <label class="form-label mt-3">Capital Narration<span class="text-danger">*</span></label>
                            <textarea name="narration" class="form-control" rows="2"></textarea>


                            <div class="d-flex mt-3 justify-content-end">
                                <input type="text" class="form-control mr-3" name="bank" style="width: 110px; !important" placeholder="Bank" >
                                <input type="text" class="form-control mr-3" name="vocher_number" style="width: 200px; !important" placeholder="Vocher Number" >
                                <button type="submit" class="btn py-2 btn-primary">Add Capital</button>
                            </div>
                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="editProffile" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable  modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title m-0" id="exampleModalLongTitle"> Edit {{ $customer->name }} Profile
                        Information </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <form action="/control/edit_customer" method="POST" class="form-validate">@csrf

                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="">Full Name <span class="error">*</span></label>
                                        <input type="text" name="name" value="{{ $customer->name }}"
                                            required="required" class="form-control">

                                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                                        @error('name')
                                            <i class="text-danger small"> {{ $message }} </i>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="">Company Name <span class="error">*</span></label>
                                        <input type="text" name="company_name" value="{{ $customer->company_name }}"
                                            class="form-control">
                                        @error('company_name')
                                            <i class="text-danger small"> {{ $message }} </i>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="">Nick Name <span class="error">*</span></label>
                                        <input type="text" name="nick_name" value="{{ $customer->nick_name }}"
                                            class="form-control">
                                        @error('nick_name')
                                            <i class="text-danger small"> {{ $message }} </i>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Email <span class="error">*</span></label>
                                        <input type="email" name="email" value="{{ $customer->email }}"
                                            class="form-control">
                                        @error('email')
                                            <i class="text-danger small"> {{ $message }} </i>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6"><label for="">Phone <span
                                                class="error">*</span></label>
                                        <input type="tel" name="phone" value="{{ $customer->phone }}"
                                            required="required" class="form-control">
                                        @error('phone')
                                            <i class="text-danger small"> {{ $message }} </i>
                                        @enderror
                                    </div>


                                    <div class="col-sm-12"><label for="" class="text-muted">Address</label>
                                        <div class="row">
                                            <div class="form-group col-sm-12"><label for="short_address">Short
                                                    address <small>(if you are not fill up this above address then you
                                                        can fill this short address)</small></label>
                                                <textarea name="address" id="short_address" placeholder="Short address" class="form-control">{{ $customer->address }}</textarea>
                                                @error('address')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="d-flex  justify-content-end">
                                        <button type="submit"
                                            class="btn btn-primary btn-lg waves-effect waves-lightml-2">
                                            <i class="fa fa-save"></i> <span>Submit</span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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


            $('.editProffile').on('click', function() {
                $('#editProffile').modal('show');
            })
        })
    </script>
@endpush
