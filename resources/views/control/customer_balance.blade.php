@extends('layouts.app')
@section('page_title')
    Csutomer Balance
@endsection

@section('page_content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Customer Management</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Customer</a></li>
                            <li class="breadcrumb-item active"> Customer Balance </li>
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
                                <span class="fs-6 text-uppercase small fw-semi-bold">Total Owning </span>
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
                                        <th class="border-0">Netweight </th>

                                        <th class="border-0">Purchased </th>
                                        <th class="border-0">Paid </th>
                                        <th class="border-0">Capital </th>
                                        <th class="border-0">Balance </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        @php
                                            $ground_balance =
                                                $customer->account_summary['total_capital'] +
                                                $customer->account_summary['total_paid'] -
                                                $customer->account_summary['total_purcahsed'];
                                        @endphp
                                        <tr>
                                            <td class="align-middle">
                                                <a href="/control/customer/{{ $customer->id }}">
                                                    {{ $customer->name }}
                                                </a>
                                            </td>
                                            <td class="align-middle">
                                                {{ $customer->nick_name }}
                                            </td>

                                            <td class="align-middle">
                                                {{ number_format($customer->account_summary['total_net_weight']) }} kg
                                            </td>
                                            <td class="align-middle">
                                                {{ money($customer->account_summary['total_purcahsed']) }}
                                            </td>
                                            <td class="align-middle">
                                                {{ money($customer->account_summary['total_paid']) }}
                                            </td>
                                            <td class="align-middle">
                                                {{ money($customer->account_summary['total_capital']) }}
                                            </td>

                                            <td class="align-middle">
                                                @if ($ground_balance != 0)
                                                    <div
                                                        class="badge {{ $ground_balance < 0 ? 'badge-success' : 'badge-danger' }} ">
                                                        {{ money(abs($ground_balance)) }}
                                                    </div>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="nav d-flex mt-3 justify-content-end ">
                        {{ $customers->links('pagination::bootstrap-4') }}
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
