@extends('layouts.app')
@section('page_title')
    Supplier Balance
@endsection

@section('page_content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Supplier Management</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Supplier</a></li>
                            <li class="breadcrumb-item active"> Supplier Balance </li>
                        </ol>
                    </div>
                </div>
            </div>


            <div class="row">


                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div>
                                <span class="fs-6 text-uppercase small fw-semi-bold">Expected Supply</span>
                            </div>
                            <h2 class="fw-bold mt-0 mb-1">
                                {{ money($total_debit) }}

                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div>
                                <span class="fs-6 text-uppercase small fw-semi-bold">Amount Payable </span>
                            </div>
                            <h2 class="fw-bold mt-0 mb-1">
                               {{ money(abs($total_credit)) }}
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card shadow">

                        <div class="table-responsive border-0 overflow-y-hidden">
                            <table class="table mb-0 text-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Name </th>
                                        <th class="border-0">Nick Name</th>

                                        <th class="border-0">Amount Supplied </th>
                                        <th class="border-0">Capital </th>
                                        <th class="border-0">Balance </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suppliers as $supplier)
                                       @php
                                           $balance = supplierCredit($supplier->id);
                                       @endphp
                                        <tr class=" {{ $supplier->balance >= 0 ? '' : 'text-danger' }} ">
                                            <td class="align-middle">
                                                <a href="/control/supplier/{{ $supplier->id }}">
                                                    {{ $supplier->name }}
                                                </a>
                                            </td>
                                            <td class="align-middle">
                                                {{ $supplier->nick_name }}
                                            </td>

                                    
                                            <td class="align-middle">
                                                {{ money($supplier->account_summary['total_purcahsed']) }}
                                            </td>
                                      
                                            <td class="align-middle">
                                                {{ money($supplier->account_summary['total_capital']) }}
                                            </td>

                                            <td class="align-middle">
                                                <div
                                                    class="badge  {{ $balance > 0 ? 'badge-danger' : 'badge-success' }} ">
                                                    {{ money(abs($balance)) }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="nav d-flex mt-3 justify-content-end ">
                        {{ $suppliers->links('pagination::bootstrap-4') }}
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
