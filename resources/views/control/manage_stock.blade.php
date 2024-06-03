@extends('layouts.app')
@section('page_title')
    Manage Stock
@endsection

@section('page_content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Stock</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Stock</a></li>
                            <li class="breadcrumb-item active">Manage Stock Flow</li>
                        </ol>
                    </div>

                    <div class="col-sm-6">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary mr-2 make_adjust">Make Adjustment</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col-md-12">

                    <div class="d-flex mb-3 justify-content-end ">
                        <button class="btn change_calculation use_tares btn-outline-primary mr-2" data-value="1">Use
                            Tares</button>
                        <input type="hidden" name="calculation_value" id="" value="1">
                        <button class="btn change_calculation use_rate btn-outline-primary" data-value="2">Use Rate</button>
                    </div>
                    @isset($_GET['edit'])
                        <div class="card mb-3 shadow" style="border: 1px solid green !important">
                            <div class="card-body">
                                <div class="d-flex mb-3 justify-content-between">
                                    <h4 class="fw-bold card-title" style="font-size: 20px"> <i
                                            class="fa fa-edit text-success "></i> Edit Transaction</h4>
                                    <div>
                                        <span class="badge fw-bold bg-warning text-white "> {{ $selected_stock->bags }} bags of
                                            {{ $selected_stock->product->name }} </span>
                                        <span class="badge fw-bold bg-success text-white ">
                                            {{ number_format($selected_stock->net_weight, 1) }} kg,
                                            {{ money($selected_stock->price) }} </span>
                                    </div>
                                </div>
                                <form action="/control/edit_stock_transaction" method="post"> @csrf
                                    <div class="row">


                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Select Product<span class="required">*</span></label>
                                                <select name="product" id="product" class="form-control">
                                                    @foreach ($products as $product)
                                                        <option value="{{ json_encode($product) }}"
                                                            {{ $product->id == $selected_stock->product_id ? 'selected' : '' }}>
                                                            {{ $product->name }} |
                                                            {{ money($product->price) }} </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="product_id" id="product_id"
                                                    class="form-control mt-2">

                                                <input type="hidden" name="stock_id" value="{{ $selected_stock->id }}">
                                                @error('product_id')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Select Client<span class="required">*</span></label>
                                                <select name="supplier" class="form-control" id="">
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}"
                                                            {{ $client->id == $selected_stock->supplier_id ? 'selected' : '' }}>
                                                            {{ $client->name }} |
                                                            {{ $client->name }} </option>
                                                    @endforeach
                                                </select>
                                                @error('supplier')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>




                                        <div class="col-xl-1">
                                            <div class="mb-3">
                                                <label class="form-label ">Bags<span class="required">*</span></label>
                                                <input type="number" step="any" name="bags"
                                                    value="{{ $selected_stock->bags }}" class="form-control"
                                                    placeholder="Total Bags">
                                                @error('bags')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Gross Weight<span class="required">*</span></label>
                                                <input type="number" step="any" name="gross_weight"
                                                    value="{{ $selected_stock->gross_weight }}" class="form-control"
                                                    placeholder="Gross weight ">
                                                @error('gross-weight')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-xl-1">
                                            <div class="mb-3">
                                                <label class="form-label ">Tares<span class="required">*</span></label>
                                                <input type="number" step="any" name="tares"
                                                    value="{{ $selected_stock->tares }}" class="form-control">
                                                @error('tares')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-xl-1">
                                            <div class="mb-3">
                                                <label class="form-label ">Mois/Dis<span class="required">*</span></label>
                                                <input type="number" step="any" min="0" name="moisture_discount"
                                                    value="{{ $selected_stock->moisture_discount }}" class="form-control">
                                                @error('moisture_discount')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Net Weight<span class="required">*</span></label>
                                                <input type="number" step="any" name="net_weight"
                                                    value="{{ old('net_weight') }}" class="form-control" placeholder=""
                                                    readonly>
                                                @error('net_weight')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-xl-1">
                                            <div class="mb-3">
                                                <label class="form-label ">Price<span class="required">*</span></label>
                                                <input type="number" step="any" name="price"
                                                    value="{{ $selected_stock->price }}" class="form-control"
                                                    placeholder="Price">
                                                @error('price')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Rate<span class="required">*</span></label>
                                                <input type="number" step="any" name="rate"
                                                    value="{{ $selected_stock->restock->rate }}" class="form-control"
                                                    placeholder="rate">
                                                @error('rate')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-6 mt-3">

                                            <div class="row  ">
                                                <div class="col-md-6 offset-6">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-end">
                                                            <p class="mb-0" style="white-space: nowrap">Final Weight:</p>
                                                        </div>
                                                        <div class="col d-flex justify-content-end">
                                                            <p class="mb-0 final_weight"> 0.00</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <h2 class="fw-bold mt-0 text-danger d-flex justify-content-end"
                                                style="font-size: 25px">
                                                Amount Due:
                                                <span class="stock_total ml-4">0.00</span>
                                            </h2>
                                        </div>



                                        {{-- <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Amount Paid<span class="required">*</span></label>
                                                <input type="number" step="any" name="amount_paid"
                                                    value="{{ $selected_stock->amount_paid }}" class="form-control"
                                                    placeholder="Amount paid">
                                                @error('amount_paid')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div> --}}




                                        <div class="col-md-4 ">
                                            <div class="d-flex justify-content-end mt-4 pt-2 ">
                                                <button class="btn btn-block  btn-info">Update Stock Transaction </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="card mb-3 shadow">
                            <div class="card-body">
                                <div class="d-flex mb-3 justify-content-between">
                                    <h4 class="fw-bold card-title">Add To Stock</h4>
                                </div>
                                <form action="/control/add-stocks" method="post"> @csrf
                                    <div class="row">


                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Select Product<span
                                                        class="required">*</span></label>
                                                <input type="hidden" name="action" value="import">
                                                <select name="product" id="product" class="form-control">
                                                    @foreach ($products as $product)
                                                        <option value="{{ json_encode($product) }}"> {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="product_id" id="product_id"
                                                    class="form-control mt-2">
                                                @error('product_id')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Select Client<span
                                                        class="required">*</span></label>
                                                <select name="supplier" class="form-control" id="">
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}"> {{ $client->name }} |
                                                            {{ $client->name }} </option>
                                                    @endforeach
                                                </select>
                                                @error('supplier')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>




                                        <div class="col-xl-1">
                                            <div class="mb-3">
                                                <label class="form-label ">Bags<span class="required">*</span></label>
                                                <input type="number" step="any" name="bags"
                                                    value="{{ old('bag') }}" class="form-control"
                                                    placeholder="Total Bags">
                                                @error('bags')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Gross Weight<span class="required">*</span></label>
                                                <input type="number" step="any" name="gross_weight"
                                                    value="{{ old('gross_weight') }}" class="form-control"
                                                    placeholder="Gross weight ">
                                                @error('gross-weight')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-xl-1">
                                            <div class="mb-3">
                                                <label class="form-label ">Tares<span class="required">*</span></label>
                                                <input type="number" step="any" name="tares"
                                                    value="{{ old('tares') }}" class="form-control">
                                                @error('tares')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-xl-1">
                                            <div class="mb-3">
                                                <label class="form-label ">Mois/Dis<span class="required">*</span></label>
                                                <input type="number" step="any" min="0" name="moisture_discount"
                                                    value="0" class="form-control">
                                                @error('moisture_discount')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Net Weight<span class="required">*</span></label>
                                                <input type="number" step="any" name="net_weight"
                                                    value="{{ old('net_weight') }}" class="form-control" placeholder=""
                                                    readonly>
                                                @error('net_weight')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-xl-1">
                                            <div class="mb-3">
                                                <label class="form-label ">Price<span class="required">*</span></label>
                                                <input type="number" step="any" name="price"
                                                    value="{{ old('price') }}" class="form-control" placeholder="Price">
                                                @error('price')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Rate<span class="required">*</span></label>
                                                <input type="number" step="any" name="rate"
                                                    value="{{ old('rate') ?? 1027 }}" class="form-control"
                                                    placeholder="rate">
                                                @error('rate')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-6 mt-3">

                                            <div class="row  ">
                                                <div class="col-md-6 offset-6">
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-end">
                                                            <p class="mb-0" style="white-space: nowrap">Final Weight:</p>
                                                        </div>
                                                        <div class="col d-flex justify-content-end">
                                                            <p class="mb-0 final_weight"> 0.00</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <h2 class="fw-bold mt-0 text-danger d-flex justify-content-end"
                                                style="font-size: 25px">
                                                Amount Due:
                                                <span class="stock_total ml-4">0.00</span>
                                            </h2>
                                        </div>


                                        {{-- 
                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Amount Paid<span class="required">*</span></label>
                                                <input type="number" step="any" name="amount_paid"
                                                    value="{{ old('amount_paid') ?? 0 }}" class="form-control"
                                                    placeholder="Amount paid">
                                                @error('amount_paid')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>

 --}}


                                        <div class="col-md-4 ">
                                            <div class="d-flex justify-content-end mt-4 pt-2 ">
                                                <button class="btn btn-block  btn-primary">Submit Stock Transaction </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endisset




                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-xl-3 col-lg-3x col-sm-6">
                                <div class="card shadow text-center">
                                    <div class="card-body">
                                        <div class="user-content">
                                            <div class="user-info">
                                                <div class="user-img">
                                                    <img src="{{ Avatar::create($product->name)->toBase64() }}"
                                                        class="rounded-circle " style="width: 50px" />
                                                </div>
                                                <div class="user-details mt-2">
                                                    <h4 class="user-name fw-bold fs-6 mb-0">{{ $product->name }}</h4>
                                                    <p>{{ money($product->price) }} |
                                                        {{ number_format($product->stock_bag) }} bags |
                                                        {{ number_format($product->stock_weight) }} kg </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" d-flex justify-content-center text-white  mb-2 mt-0">
                                            <span
                                                class="badge bg-danger light">{{ date('j M, Y', strtotime($product->created_at)) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-center ">
                                            <a href="/control/general-stock-legder/{{ $product->id }}"
                                                class="btn-secondary shadow mt-2 btn-sm w-50"><i
                                                    class="fa fa-book mr-2"></i>Stock Ledger</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <div class="card shadow">
                        <!-- Card header -->
                        <div class="card-header border-bottom-0 fw-bold">
                            <span class="fw-bold">Ledger For all Products </span>
                            <div class="alert mt-2 alert-info">
                                Click on stock ledger to view the transaction details of a single product
                            </div>
                        </div>
                        <!-- Table -->
                        <div class="table-responsive border-0 overflow-y-hidden">
                            <table class="table mb-0 text-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Date </th>
                                        <th class="border-0">Client </th>
                                        <th class="border-0">Commodity </th>
                                        <th class="border-0">Gross/<br>weight </th>
                                        <th class="border-0">Bags </th>
                                        <th class="border-0">Tares</th>
                                        <th class="border-0">Mois/<br>dis</th>
                                        <th class="border-0">Rate</th>
                                        <th class="border-0">Net/<br>weight </th>
                                        <th class="border-0">Price </th>
                                        <th class="border-0">Total</th>
                                        <th class="border-0">Added By</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stocks as $stock)
                                        @if ($stock->action == 'import')
                                            <tr class=" {{ $stock->bags > 0 ? 'text-success' : 'text-danger' }} ">
                                                <td class="align-middle">
                                                    {{ date('j F Y', strtotime($stock->created_at)) }}
                                                </td>
                                                <td class="align-middle">
                                                    <span class="fw-bold"> <a
                                                            href="/control/supplier/{{ $stock->supplier_id }}">{{ $stock->client->name }}</a>
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    {{ $stock->product->name }}
                                                </td>

                                                <td class="align-middle">{{ number_format($stock->gross_weight) }}</td>
                                                <td class="align-middle">
                                                    <div
                                                        class="badge {{ $stock->bags > 0 ? ' badge-success' : 'badge-danger' }} badge-success">
                                                        {{ abs($stock->bags) }}
                                                    </div>
                                                </td>

                                                <td class="align-middle">{{ number_format($stock->tares) }}</td>
                                                <td class="align-middle">{{ number_format($stock->moisture_discount) }}
                                                </td>
                                                <td class="align-middle">{{ number_format($stock->rate) }}</td>


                                                <td class="align-middle">
                                                    <div
                                                        class="badge {{ $stock->net_weight > 0 ? ' badge-info' : 'badge-warning' }}">
                                                        {{ number_format(abs($stock->net_weight)) }} kg
                                                    </div>
                                                </td>


                                                <td class="align-middle">
                                                    {{ money($stock->price) }}
                                                </td>
                                                <td class="align-middle">
                                                    <span class="fw-semi-bold"
                                                        style="font-weight: 600">{{ money($stock->total) }}</span>
                                                </td>


                                                <td class="align-middle">
                                                    {{ $stock->user->name }}
                                                </td>
                                                <td class="align-middle ">
                                                    <div class="d-flex  justify-content-end">




                                                        @if ($stock->bags_out == 0)
                                                            <a href="/control/manage-stock?edit={{ $stock->id }}&&action=edit"
                                                                style="border-radius: 4px; font-size : 20px "
                                                                class="fw-bold text-info mr-2"> <i class="fa fa-edit"></i>
                                                            </a>


                                                            <a href="/control/delete_stock_act/{{ $stock->id }}"
                                                                style="border-radius: 4px; font-size : 20px "
                                                                onclick="return confirm('This transaction will be totally removed from database ')"
                                                                class="fw-bold text-danger"> <i class="fa fa-trash"></i>
                                                            </a>
                                                        @endif

                                                        {{-- <a href="javascript:;" style="border-radius: 4px; font-size : 20px "
                                                    class="fw-bold text-success ml-2 adjustment "
                                                    data-data=" {{ json_encode($stock) }} "> <i
                                                        class="fa fa-pen"></i>
                                                </a> --}}



                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            <tr class="text-warning ">
                                                <td class="align-middle">
                                                    {{ date('j F Y', strtotime($stock->created_at)) }}
                                                </td>
                                                <td class="align-middle">
                                                    <span class="fw-bold"> <a
                                                            href="/control/supplier/{{ $stock->supplier_id }}">{{ $stock->client->name }}</a>
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    {{ $stock->product->name }}
                                                </td>

                                                <td class="align-middle">-</td>
                                                <td class="align-middle">
                                                    -
                                                </td>

                                                <td class="align-middle">-</td>
                                                <td class="align-middle">-</td>
                                                <td class="align-middle">-</td>
                                                <td class="align-middle">
                                                    <div class="badge badge-warning">
                                                        {{ number_format(abs($stock->net_weight)) }} kg
                                                    </div>
                                                </td>


                                                <td class="align-middle">
                                                    {{ money($stock->price) }}
                                                </td>
                                                <td class="align-middle">
                                                    <span class="fw-semi-bold"
                                                        style="font-weight: 600">{{ money($stock->total) }}</span>
                                                </td>


                                                <td class="align-middle">
                                                    {{ $stock->user->name }}
                                                </td>
                                                <td class="align-middle ">
                                                    <div class="d-flex  justify-content-end">



                                                        <a href="/control/delete_stock_act/{{ $stock->id }}"
                                                            style="border-radius: 4px; font-size : 20px "
                                                            onclick="return confirm('This transaction will be totally removed from database ')"
                                                            class="fw-bold text-danger"> <i class="fa fa-trash"></i>
                                                        </a>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
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



    <div class="modal fade" id="make_adjustment" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title m-0" id="exampleModalLongTitle">Make Adjustment </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form method="POST" class="row" action="/control/adjustment">
                        @csrf


                        <div class="col-lg-5">
                            <div class="mb-3">
                                <label class="form-label ">Select Client<span class="required">*</span></label>
                                <select name="supplier_id" class="form-control" id="">
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"> {{ $client->name }} |
                                            {{ $client->name }} </option>
                                    @endforeach
                                </select>
                                @error('supplier')
                                    <i class="text-danger small"> {{ $message }} </i>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-7 mb-2 ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">Adjustment Type</label>
                                        <select name="adjustment" class="form-control" id="">
                                            <option>mositure adjustment</option>
                                            <option>price adjustment</option>
                                            <option>tares adjustment</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">Commodity</label>
                                        <select name="product_id" class="form-control">
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">
                                                    {{ $product->name }} </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Kilogram (KG)</label>
                                <input type="number" class="form-control" step="any" name="change_value">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Price </label>
                                <input type="number" step="any" class="form-control" name="change_price">
                            </div>

                            {{-- <input type="hidden" class="form-control" name="change_net_weight">
                            <input type="hidden" class="form-control" name="change_price">
                            <input type="hidden" class="form-control" name="stock_id"> --}}
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Adjustment Total <span class="text-danger">*</span></label>
                                <input type="number" step="any" class="form-control" name="adjustment_total">
                            </div>
                        </div>

                        <div class="col-md-12">

                            <div class="mb-3 mt-2">
                                <label for="">Narration</label>
                                <textarea name="remark" class="form-control" id=""></textarea>
                            </div>
                            <div class="d-flex mt-3 justify-content-end">
                                <button type="submit" class="btn py-2 btn-primary">Submit Adjustment </button>
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

            function calculateNetWeight(gross_weight, discount, rate, tares, type = 1) {
                // gross_weight = parseInt(gross_weight);
                // discount = parseInt(discount);
                // tares = parseInt(tares);

                if (type == 2) {
                    net_weight = (gross_weight / rate) * 1000;
                    console.log(net_weight);
                    return net_weight;
                } else {
                    console.log('fucker');
                    console.log(discount, tares);
                    return (gross_weight - discount) - tares
                }
            }



            const money_format = (num) => {
                var numb = new Intl.NumberFormat();
                return '₦ ' + numb.format(num);
            }


            function useCal(type) {

                if (type == 1) {
                    $('.use_tares').html('Using Tares');
                    $('.use_tares').removeClass('btn-outline-primary');
                    $('.use_tares').addClass('btn-outline-success');

                    $('.use_rate').removeClass('btn-outline-success');
                    $('.use_rate').addClass('btn-outline-primary');
                } else {
                    $('.use_rate').html('Using Rate');
                    $('.use_rate').removeClass('btn-outline-primary');
                    $('.use_rate').addClass('btn-outline-success');


                    $('.use_tares').removeClass('btn-outline-success');
                    $('.use_tares').addClass('btn-outline-primary');

                }
            }



            function makeDisplay() {

                product = $('#product').val();

                product = JSON.parse(product);

                $('#product_id').val(product.id)


                bags = $('input[name="bags"]').val();
                gross_weight = $('input[name="gross_weight"]').val();
                rate = $('input[name="rate"]').val();
                discount = $('input[name="moisture_discount"]').val()

                // net_weight = $('input[name="net_weight"]');

                tares = $('input[name="tares"]');
                tares_kg = tares.val();

                if (!tares_kg || tares_kg == 0) {
                    tares_kg = (bags * 1.5);
                    tares.val(tares_kg);
                }

                price = $('input[name="price"]');
                price_kg = price.val();

                if (!price_kg || price_kg == 0) {
                    price_kg = product.price
                    price.val(product.price);
                }

                calculation_value = $('input[name="calculation_value"]').val();
                useCal(calculation_value);

                net_kg = calculateNetWeight(gross_weight, parseInt(discount), rate, tares_kg, calculation_value)
                console.log(net_kg);
                $('input[name="net_weight"]').val(net_kg.toFixed(3));


                $('.final_weight').html(net_kg.toFixed(2))
                $('.stock_total').html(money_format(price_kg * net_kg));
            }


            $('input[name="bags"]').on('change', function() {
                makeDisplay();
            })

            $('input[name="gross_weight"]').on('change', function() {
                makeDisplay();
            })
            $('input[name="tares"]').on('change', function() {
                makeDisplay();
            })
            $('input[name="moisture_discount"]').on('change', function() {
                makeDisplay();
            })
            $('input[name="rate"]').on('change', function() {
                makeDisplay();
            })

            $('input[name="price"]').on('change', function() {
                makeDisplay();
            })

            $('#product').on('change', function() {

                product = $('#product').val();

                product = JSON.parse(product);


                $('input[name="price"]').val(product.price)
                makeDisplay();
            })


            $('body').on('click', '.change_calculation', function() {
                type = $(this).data('value');
                $('input[name="calculation_value"]').val(type);
                makeDisplay();
            })





            makeDisplay();
        })
    </script>

    <script>
        $(function() {


            $('body').on('click', '.sundry_loss', function() {
                modal = $('#sundry');

                modal.modal('show');

            })

            $('body').on('click', '.make_adjust', function() {
                // data = $(this).data('data');
                // data = JSON.parse(data);
                // console.log(data);
                modal = $('#make_adjustment');

                modal.modal('show');

                // modal.find('.dis-text').html(`
            //     <div class="d-flex justify-between " >
            //             <span class="badge mr-1 bg-info" >Net Weight : ${data.net_weight} </span>
            //             <span class="badge mr-1 bg-success" >Tares : ${data.tares} </span>
            //             <span class="badge mr-1 bg-warning" >Pirce : ${data.price} </span>
            //             <span class="badge mr-1 bg-danger" >Moisture Dis : ${data.moisture_discount} </span>
            //     </div>
            // `)

                // modal.find('input[name="change_net_weight"]').val(data.net_weight);
                // modal.find('input[name="change_price"]').val(data.price);
                // modal.find('input[name="stock_id"]').val(data.id);
            })


            $('input[name="change_value"]').on('keyup', function() {
                calculateTotal();
            })

            $('select[name="adjustment"]').on('keyup', function() {
                calculateTotal();
            })


            function calculateTotal() {
                action = $('select[name="adjustment"]').val();
                change_value = $('input[name="change_value"]').val();
                net_weight = $('input[name="change_net_weight"]').val();
                price = $('input[name="change_price"]').val();
                total = $('input[name="adjustment_total"]');
                console.log(action, change_value, net_weight);
                if (action == 'price') {
                    total.val(net_weight * change_value);
                }

                if (action == 'mositure') {
                    total.val(price * change_value);
                }

                if (action == 'tares') {
                    total.val(price * change_value);
                }
            }
        })
    </script>
@endpush
