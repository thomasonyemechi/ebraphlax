@extends('layouts.app')
@section('page_title')
    Stock Ledger
@endsection

@section('page_content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Stock Ledger</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Stock Ledger</a></li>
                            <li class="breadcrumb-item active"> {{ $product->name }} Ledger</li>
                        </ol>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                    <!-- Card -->
                    <div class="card shadow mb-4">
                        <!-- Card body -->
                        <div class="card-body">
                            <div>
                                <span class="fs-6 text-uppercase small fw-semi-bold">Total Stock</span>
                            </div>
                            <h2 class="fw-bold mt-0 mb-1">
                                {{ number_format($total_stock) }} 
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div>
                                <span class="fs-6 text-uppercase small fw-semi-bold">Bag Bal</span>
                            </div>
                            <h2 class="fw-bold mt-0 mb-1">
                                {{ number_format($bag_balance) }} 
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div>
                                <span class="fs-6 text-uppercase small fw-semi-bold">Weight Bal</span>
                            </div>
                            <h2 class="fw-bold mt-0 mb-1">
                                {{ number_format($weight_balance) }} KG
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div>
                                <span class="fs-6 text-uppercase small fw-semi-bold">Total In</span>
                            </div>
                            <h2 class="fw-bold mt-0 mb-1">
                                {{ number_format($total_in) }} 
                            </h2>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-12">
                    <div class="card shadow">

                        <div class="table-responsive border-0 overflow-y-hidden">
                            <table class="table mb-0 text-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Date </th>
                                        <th class="border-0">Customer Name </th>
                                        <th class="border-0">Commodity </th>
                                        <th class="border-0">Bags In </th>
                                        <th class="border-0">Weight In </th>
                                        <th class="border-0">Bags Out </th>
                                        <th class="border-0">Weight Out </th>
                                        <th class="border-0">Bag Bal </th>
                                        <th class="border-0">Weight Bal </th>
                                        <th class="border-0">Added By</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stocks as $stock)
                                        <tr class=" {{ $stock->bag > 0 ? 'text-success' : 'text-danger' }} ">
                                            <td class="align-middle">{{ date('j F Y', strtotime($stock->created_at)) }}
                                            </td>
                                            <td class="align-middle">
                                                {{ $stock->client_name }}
                                            </td>
                                            <td class="align-middle">
                                                {{ $stock->product->name }}
                                            </td>
                                            {{-- bags in --}}
                                            <td class="align-middle">
                                                @if ($stock->bag > 0)
                                                    <div class="badge badge-success">
                                                        {{ abs($stock->bag) }}
                                                    </div>
                                                @endif
                                            </td>
                                            {{-- weight in --}}
                                            <td class="align-middle">
                                                @if ($stock->weight > 0)
                                                    <div class="badge badge-info">
                                                        {{ number_format(abs($stock->weight)) }} kg
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                @if ($stock->bag < 0)
                                                    <div class="badge badge-danger">
                                                        {{ abs($stock->bag) }}
                                                    </div>
                                                @endif
                                            </td>


                                            <td class="align-middle">
                                                @if ($stock->weight < 0)
                                                    <div class="badge badge-danger">
                                                        {{ abs($stock->weight) }}
                                                    </div>
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
                                                <a href="/control/delete-stock/{{ $stock->id }}"
                                                    onclick="return confirm('This transaction will be deleted')"
                                                    class="mr-2 btn-danger shadow text-white px-2"> <i
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
@endpush
