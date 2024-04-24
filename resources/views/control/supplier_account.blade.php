@extends('layouts.app')
@section('page_title')
Supplier Account
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
                        <li class="breadcrumb-item active"> Supplier Bank Details </li>
                    </ol>
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
                                <th class="border-0">Bank </th>
                                <th class="border-0">Account Number </th>
                                <th class="border-0">Account Name </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                            <tr class=" {{ $supplier->balance >= 0 ? '' : 'text-danger' }} ">
                                <td class="align-middle">
                                    <a href="/control/supplier/{{ $supplier->id }}">
                                        {{ $supplier->name }} ( {{ $supplier->nick_name }})
                                    </a>
                                </td>
                                <td class="align-middle">
                                    {{ $supplier->bank }}
                                </td>

                                <td class="align-middle">
                                    {{ $supplier->bank_account }}
                                </td>

                                <td class="align-middle">
                                    {{ $supplier->account_name }} 
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
