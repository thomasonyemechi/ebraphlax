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
                            <li class="breadcrumb-item active">Manage Stock</li>
                        </ol>
                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col-md-12">

                    <div class="card mb-3 shadow">
                        <div class="card-body">
                            <div class="d-flex mb-3 justify-content-between">
                                <h4 class="fw-bold card-title">Add To Stock</h4>
                            </div>
                            <form action="/control/add_store_stock" method="post"> @csrf
                                <div class="row">

                                    <div class="col-xl-1">
                                        <div class="mb-3">
                                            <label class="form-label "> Action<span class="required">*</span></label>
                                            <select name="action" id="action" class="form-control px-1">
                                                <option>import</option>
                                                <option>export</option>
                                                <option>sundry loss</option>
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
                                            <label class="form-label ">Select Product<span class="required">*</span></label>
                                            <select name="product_id" class="form-control">
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

                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label class="form-label ">Select Client<span class="required">*</span></label>
                                            <select name="supplier_id" id="supplier" class="form-control">
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}"> {{ $supplier->id }}
                                                        {{ $supplier->name }} |
                                                        {{ $supplier->phone }} </option>
                                                @endforeach
                                            </select>



                                            <select name="customer_id" id="customer" class="form-control"
                                                style="display: none">
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}"> {{ $customer->id }}
                                                        {{ $customer->name }} |
                                                        {{ $customer->phone }} </option>
                                                @endforeach
                                            </select>


                                            @error('supplier')
                                                <i class="text-danger small"> {{ $message }} </i>
                                            @enderror
                                        </div>
                                    </div>




                                    <div class="col-xl-2">
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
                                            <label class="form-label ">Weight<span class="required">*</span></label>
                                            <input type="number" step="any" name="weight" value="{{ old('weight') }}"
                                                class="form-control" placeholder="">
                                            @error('weight')
                                                <i class="text-danger small"> {{ $message }} </i>
                                            @enderror
                                        </div>
                                    </div>




                                    <div class="col-md-2 ">
                                        <div class="d-flex justify-content-end mt-4 pt-2 ">
                                            <button class="btn btn-block  btn-primary">Submit Transaction </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



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

                                        <div class="d-flex justify-content-center ">
                                            <a href="/control/stock/{{ $product->id }}"
                                                class=" btn  btn-primary border-2 shadow mt-2 btn-sm w-50"><i
                                                    class="fa fa-book mr-2"></i> Ledger</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <div class="card shadow">
                        <!-- Card header -->
                        <div class="card-header border-bottom-0 fw-bold">
                            <span class="fw-bold"> Store Keeper Ledger </span>
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
                                        <th class="border-0">Bags in </th>
                                        <th class="border-0">Weight in </th>
                                        <th class="border-0">Bags Out </th>
                                        <th class="border-0">Weight Out </th>
                                        <th class="border-0">Bag Bal </th>
                                        <th class="border-0">Wei Bal </th>
                                        <th class="border-0">Added By</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stocks as $stock)
                                        <tr class=" {{ $stock->bags > 0 ? 'text-success' : 'text-danger' }} ">
                                            <td class="align-middle">{{ date('j F Y', strtotime($stock->created_at)) }}
                                            </td>
                                            <td class="align-middle">
                                                {{ $stock->client->name }}
                                            </td>
                                            <td class="align-middle">
                                                {{ $stock->product->name }}
                                            </td>

                                            <td class="align-middle">

                                                @if ($stock->bags > 0)
                                                    <div
                                                        class="badge {{ $stock->bags > 0 ? ' badge-success' : 'badge-danger' }} badge-success">
                                                        {{ number_format(abs($stock->bags), 1) }}
                                                    </div>
                                                @else
                                                    -
                                                @endif

                                            </td>

                                            <td class="align-middle">
                                                @if ($stock->weight > 0)
                                                    <div
                                                        class="badge {{ $stock->weight > 0 ? ' badge-success' : 'badge-danger' }} badge-success">
                                                        {{ number_format(abs($stock->weight)) }}
                                                    </div>
                                                @else
                                                    -
                                                @endif

                                            </td>


                                            <td class="align-middle">

                                                @if ($stock->bags < 0)
                                                    <div
                                                        class="badge {{ $stock->bags < 0 ? ' badge-info' : 'badge-warning' }}">
                                                        {{ number_format(abs($stock->bags)) }}
                                                    </div>
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td class="align-middle">
                                                @if ($stock->weight < 0)
                                                    <div
                                                        class="badge {{ $stock->weight < 0 ? ' badge-info' : 'badge-warning' }}">
                                                        {{ number_format(abs($stock->weight)) }} kg
                                                    </div>
                                                @else
                                                    -
                                                @endif
                                            </td>


                                            <td class="align-middle">
                                                {{ number_format($stock->bag_balance) }}
                                            </td>

                                            <td class="align-middle">
                                                {{ number_format($stock->weight_balance) }}
                                            </td>

                                            <td class="align-middle">
                                                {{ $stock->user->name }}
                                            </td>
                                            <td class="align-middle ">
                                                <a onclick="return confirm('This transaction will be deleted')" href="/control/delete_store_stock/{{$stock->id}}"
                                                    class="mr-2 btn-danger py-1 shadow text-white px-2" style="border-radius: 4px;" > <i
                                                        class="fa fa-trash"></i> </a>
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


@push('scripts')
    <script>
        $(function() {
            $('#action').on('change', function() {
                val = $(this).val();
                console.log(val);


                if (val == 'import') {
                    $('#supplier').show();
                    $('#customer').hide();

                } else {
                    $('#supplier').hide();
                    $('#customer').show();
                }
            })
        })
    </script>
@endpush
