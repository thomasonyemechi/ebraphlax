@extends('layouts.app')
@section('page_title')
    Manage Branch Stock
@endsection

@section('page_content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Manage Branch Stock</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Stock</a></li>
                            <li class="breadcrumb-item active">Branch Stock</li>
                        </ol>
                    </div>
                </div>
            </div>


            <div class="row">

                @foreach ($branches as $ware)
                    <div class="col-md-12">

                        <div class="card "
                            @if ($ware->id == 1) style="border: 3px solid green !important" @else  style="border: 3px solid red !important" @endif>
                            <div class="card-body">
                                <h4> {{ $ware->name }} </h4>
                                <p> {{ $ware->address }} </p>
                                <p> {{ $ware->phone }} </p>
                                <div class="row">
                                    @foreach ($ware->products as $product)
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
                                                                <h4 class="user-name fw-bold fs-6 mb-0">{{ $product->name }}
                                                                </h4>|
                                                                {{ number_format($product->stock_bag) }} bags |
                                                                {{ number_format($product->stock_weight) }} kg </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row">
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
                                                @foreach ($ware->stocks->take(20) as $stock)
                                                    <tr class=" {{ $stock->bags > 0 ? 'text-success' : 'text-danger' }} ">
                                                        <td class="align-middle">
                                                            {{ date('j F Y', strtotime($stock->created_at)) }}
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
                                                            <a onclick="return confirm('This transaction will be deleted')"
                                                                href="/control/delete_store_stock/{{ $stock->id }}"
                                                                class="mr-2 btn-danger py-1 shadow text-white px-2"
                                                                style="border-radius: 4px;"> <i class="fa fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div class="d-flex justify-content-lg-end ">
                                            <a class="btn btn-info mt-3 px-5" href="/control/branch_stock/{{ $ware->id }}" >View all stock transaction</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

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
