@extends('layouts.app')
@section('page_title')
    Suppliers
@endsection

@section('page_content')
    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Supplier Profile</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Suppliers</a></li>
                            <li class="breadcrumb-item active"> {{ $supplier->name }} </li>
                        </ol>

                    </div>
                    <div class="col-sm-3 offset-3">
                        <div class="d-flex justify-content-end ">
                            <div class="input-group mr-3  ">
                                <input type="search" name="supplier" class="form-control"
                                    placeholder="Enter Supplier's name and click enter" style="width: 150px !important;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">


                <div class="col-md-4">
                    <div class="card ">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="{{ Avatar::create($supplier->name)->toBase64() }}" />
                                <h2 class="fw-bold mt-2" style="font-size: 25px"> {{ $supplier->name }} |
                                    {{ $supplier->nick_name }} </h2>
                                <p class="mb-0"> {{ $supplier->address }} </p>

                            </div>

                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span>Phone</span>
                                <span class="text-warning">
                                    {{ $supplier->phone }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span>Email</span>
                                <span>
                                    {{ $supplier->email }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span>Type</span>

                                @if ($total_capital > 0)
                                    <div class="badge badge-success ">
                                        Advance
                                    </div>
                                @else
                                    <div class="badge badge-primary">
                                        See and buy
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="d-flex mb-3  justify-content-between">
                        <button class="btn btn-primary editProffile "> Update Profile </button>
                        {{-- <button class="btn btn-info "> View Ledger </button> --}}
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
                                                <td>{{ money($capital->total) }}</td>
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
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex  justify-content-between ">
                                <h5 class="fw-bold">Ledger</h5>
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
                                        {{-- <th class="align-middle">Ext Price</th>
                                        <th class="align-middle">Ammount Paid</th> --}}
                                        <th class="align-middle">Debit</th>

                                        <th class="align-middle">Credit </th>

                                        <th class="align-middle">Balance </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($stocks as $stock)
                                        @php
                                            $amount_paid = getAmmountPaid($stock->summary_id);
                                        @endphp
                                        @if ($stock->action == 'import')
                                            <tr>
                                                <td> {{ $stock->created_at }} </td>
                                                <td> {{ $stock->product->name }} Import </td>
                                                <td> {{ number_format(abs($stock->bags)) }} </td>
                                                <td> {{ number_format(abs($stock->gross_weight)) }} </td>

                                                <td> {{ abs($stock->bags * 1.5) }} </td>
                                                <td> {{ number_format(abs($stock->moisture_discount)) }} </td>
                                                <td> {{ number_format(abs($stock->net_weight)) }} </td>
                                                <td> {{ money($stock->price) }} </td>
                                                <td>-</td>

                                                <td> {{ money($stock->total) }} </td>
                                                <td> {{ money($stock->current_balance) }} </td>


                                            </tr>
                                        @elseif($stock->action == 'capital')
                                            <tr>
                                                <td> {{ $stock->created_at }} </td>
                                                <td> {{ $stock->remark ?? 'Capital Given' }} </td>
                                                <td> - </td>
                                                <td> - </td>
                                                <td> - </td>
                                                <td> - </td>
                                                <td> - </td>
                                                <td>-</td>
                                                <td> {{ money($stock->total) }} </td>

                                                <td>-</td>
                                                <td> {{ money($stock->current_balance + $stock->total) }} </td>

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
                            <input type="hidden" name="action" value="import">
                            <input type="hidden" name="user_id" value="{{ $supplier->id }}">

                            <label class="form-label mt-3">Capital Narration<span class="text-danger">*</span></label>
                            <textarea name="narration" class="form-control" rows="2"></textarea>

                            <div class="d-flex mt-3 justify-content-end">
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
                    <h5 class="modal-title m-0" id="exampleModalLongTitle"> Edit {{ $supplier->name }} Profile
                        Information </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <form action="/control/edit_supplier" method="POST" class="form-validate">@csrf

                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="">Full Name <span class="error">*</span></label>
                                        <input type="text" name="name" value="{{ $supplier->name }}"
                                            required="required" class="form-control">

                                        <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">

                                        @error('name')
                                            <i class="text-danger small"> {{ $message }} </i>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="">Company Name <span class="error">*</span></label>
                                        <input type="text" name="company_name" value="{{ $supplier->company_name }}"
                                            class="form-control">
                                        @error('company_name')
                                            <i class="text-danger small"> {{ $message }} </i>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="">Nick Name <span class="error">*</span></label>
                                        <input type="text" name="nick_name" value="{{ $supplier->nick_name }}"
                                            class="form-control">
                                        @error('nick_name')
                                            <i class="text-danger small"> {{ $message }} </i>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Email <span class="error">*</span></label>
                                        <input type="email" name="email" value="{{ $supplier->email }}"
                                            class="form-control">
                                        @error('email')
                                            <i class="text-danger small"> {{ $message }} </i>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6"><label for="">Phone <span
                                                class="error">*</span></label>
                                        <input type="tel" name="phone" value="{{ $supplier->phone }}"
                                            required="required" class="form-control">
                                        @error('phone')
                                            <i class="text-danger small"> {{ $message }} </i>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Bank Name <span class="error">*</span></label>
                                        <input type="text" name="bank" value="{{ $supplier->bank }}"
                                            required="required" class="form-control">
                                        @error('bank')
                                            <i class="text-danger small"> {{ $message }} </i>
                                        @enderror
                                    </div>


                                    <div class="col-md-4">
                                        <label for="">Account Number <span class="error">*</span></label>
                                        <input type="text" name="bank_account" value="{{ $supplier->bank_account }}"
                                            required="required" class="form-control">
                                        @error('bank_account')
                                            <i class="text-danger small"> {{ $message }} </i>
                                        @enderror
                                    </div>


                                    <div class="col-md-4">
                                        <label for="">Account Name <span class="error">*</span></label>
                                        <input type="text" name="account_name" value="{{ $supplier->account_name }}"
                                            required="required" class="form-control">
                                        @error('account_name')
                                            <i class="text-danger small"> {{ $message }} </i>
                                        @enderror
                                    </div>


                                    <div class="col-sm-12"><label for="" class="text-muted">Address</label>
                                        <div class="row">
                                            <div class="form-group col-sm-12"><label for="short_address">Short
                                                    address <small>(if you are not fill up this above address then you
                                                        can fill this short address)</small></label>
                                                <textarea name="address" id="short_address" placeholder="Short address" class="form-control">{{ $supplier->address }}</textarea>
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
