@extends('layouts.app')
@section('page_title')
    Manage Export Transaction
@endsection

@section('page_content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Export Transaction</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Stock</a></li>
                            <li class="breadcrumb-item active">Export Transaction</li>
                        </ol>
                    </div>

                    <div class="col-sm-6">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary make_adjust">Add to Ledger</button>
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
                                            class="fa fa-edit text-success "></i> Edit Export Transaction</h4>
                                    <div>
                                        <span class="badge fw-bold bg-warning text-white "> {{ $selected_stock->bags }} bags of
                                            {{ $selected_stock->product->name }} </span>
                                        <span class="badge fw-bold bg-success text-white ">
                                            {{ number_format($selected_stock->net_weight, 1) }} kg,
                                            {{ money($selected_stock->price) }} </span>
                                    </div>
                                </div>



                                <form action="/control/update_export" method="post"> @csrf
                                    <div class="row">                               
                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Select Product<span class="required">*</span></label>
                                                <input type="hidden" name="stock_id" value="{{ $selected_stock->id }}" >

                                                <select name="product_id" id="product" class="form-control">
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}" {{ $product->id == $selected_stock->product_id ? 'selected' : '' }} > {{ $product->name }} |
                                                            {{ money($product->price) }} </option>
                                                    @endforeach
                                                </select>
                                                @error('product_id')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Select Client<span class="required">*</span></label>
                                                <select name="exporter" class="form-control" id="">
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}" {{ $client->id == $selected_stock->customer_id ? 'selected' : '' }}> {{ $client->name }} |
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
                                                <input type="number" step="any" name="bags" value="{{ $selected_stock->bags }}"
                                                    class="form-control" placeholder="Total Bags">
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
                                                <input type="number" step="any" name="tares" value="{{ $selected_stock->tares }}"
                                                    class="form-control">
                                                @error('tares')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-xl-1">
                                            <div class="mb-3">
                                                <label class="form-label ">Mois/Dis<span class="required">*</span></label>
                                                <input type="number" step="any" min="0" name="moisture_discount"
                                                    value="{{ $selected_stock->mositure_discount }}" class="form-control">
                                                @error('moisture_discount')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Net Weight<span class="required">*</span></label>
                                                <input type="number" step="any" name="net_weight"
                                                    value="{{ $selected_stock->net_weight }}" class="form-control" placeholder="">
                                                @error('net_weight')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-xl-1">
                                            <div class="mb-3">
                                                <label class="form-label ">Price<span class="required">*</span></label>
                                                <input type="number" step="any" name="price"
                                                    value="{{ $selected_stock->price }}" class="form-control" placeholder="Price">
                                                @error('price')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Rate<span class="required">*</span></label>
                                                <input type="number" step="any" name="rate"
                                                    value="{{ $selected_stock->rate ?? 0 }}" class="form-control"
                                                    placeholder="rate">
                                                @error('rate')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>





                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Total<span class="required">*</span></label>
                                                <input type="number" step="any" name="total"
                                                    value="{{ $selected_stock->total }}" class="form-control" placeholder="000">
                                                @error('rate')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>






                                        <div class="col-md-4 ">
                                            <div class="d-flex justify-content-end mt-4 pt-2 ">
                                                <button class="btn btn-block  btn-success">Update Export Transaction </button>
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
                                    <h4 class="fw-bold card-title">Create Export Transaction</h4>
                                </div>
                                <form action="/control/add_export_ledger" method="post"> @csrf
                                    <div class="row">


                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Select Product<span class="required">*</span></label>
                                                <select name="product_id" id="product" class="form-control">
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}"> {{ $product->name }} |
                                                            {{ money($product->price) }} </option>
                                                    @endforeach
                                                </select>
                                                @error('product_id')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Select Client<span class="required">*</span></label>
                                                <select name="exporter" class="form-control" id="">
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
                                                <input type="number" step="any" name="bags" value="{{ old('bag') }}"
                                                    class="form-control" placeholder="Total Bags">
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
                                                <input type="number" step="any" name="tares" value="{{ old('tares') }}"
                                                    class="form-control">
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
                                                    value="{{ old('net_weight') }}" class="form-control" placeholder="">
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





                                        <div class="col-xl-2">
                                            <div class="mb-3">
                                                <label class="form-label ">Total<span class="required">*</span></label>
                                                <input type="number" step="any" name="total"
                                                    value="{{ old('total') }}" class="form-control" placeholder="000">
                                                @error('rate')
                                                    <i class="text-danger small"> {{ $message }} </i>
                                                @enderror
                                            </div>
                                        </div>






                                        <div class="col-md-4 ">
                                            <div class="d-flex justify-content-end mt-4 pt-2 ">
                                                <button class="btn btn-block  btn-success">Submit Stock Transaction </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endisset

                    <div class="card shadow">
                        <!-- Card header -->
                        <div class="card-header border-bottom-0 fw-bold">
                            <span class="fw-bold">Export Ledger </span>

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
                                        <tr class="text-warning ">
                                            <td class="align-middle">
                                                {{ date('j F Y', strtotime($stock->created_at)) }}
                                            </td>
                                            <td class="align-middle">
                                          <span class="fw-bold" ><a href="/control/customer/{{$stock->customer_id}}">      {{ $stock->client->name }}</a>  </span>
                                            </td>
                                            <td class="align-middle">
                                                {{ $stock->product->name }}
                                            </td>

                                            <td class="align-middle"> {{ number_format($stock->gross_weight) }}</td>
                                            <td class="align-middle">
                                                {{ number_format($stock->bags) }}
                                            </td>

                                            <td class="align-middle"> {{ number_format($stock->tares) }}</td>
                                            <td class="align-middle"> {{ number_format($stock->moisture_discount) }}</td>
                                            <td class="align-middle"> {{ number_format($stock->rate) }}</td>
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


                                            
                                                    <a href="/control/make_export_ledger?edit={{ $stock->id }}&&action=edit"
                                                        style="border-radius: 4px; font-size : 20px "
                                                        class="fw-bold text-info mr-2"> <i class="fa fa-edit"></i>
                                                    </a>



                                                    <a href="/control/delete_export_act/{{ $stock->id }}"
                                                        style="border-radius: 4px; font-size : 20px "
                                                        onclick="return confirm('This transaction will be totally removed from database ')"
                                                        class="fw-bold text-danger"> <i class="fa fa-trash"></i>
                                                    </a>

                                                </div>
                                            </td>
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



@endsection
