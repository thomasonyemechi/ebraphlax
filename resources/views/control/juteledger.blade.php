@extends('layouts.app')
@section('page_title')
    {{$client->name}} Jute Bag Ledger 
@endsection

@section('page_content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Jute bags</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Control</a></li>
                            <li class="breadcrumb-item active">Jute Ledger - {{$client->name}}</li>
                        </ol>
                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col-md-12">

               
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card shadow mt-3 border-2 ">
                                <div class="card-body  ">
                                    <div>
                                        <span class="fs-6 text-uppercase small fw-semi-bold">Jute Bags In</span>
                                    </div>
                                    <h2 class="fw-bold mt-0 text-info mb-1">
                                        {{ number_format(abs(App\Models\Jutebag::where(['client_type' => $client_type, 'client_id' => $client_id,  ['amount', '>', '0']])->sum('amount'))) }}
                                    </h2>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card shadow mt-3 border-2 ">
                                <div class="card-body">
                                    <div>
                                        <span class="fs-6 text-uppercase small fw-semi-bold">Jute Bags Out</span>
                                    </div>
                                    <h2 class="fw-bold text-warning mt-0 mb-1">
                                        {{ number_format(abs(App\Models\Jutebag::where(['client_type' => $client_type, 'client_id' => $client_id, ['amount', '<', '0']])->sum('amount'))) }}
                                    </h2>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="card shadow mt-3 border-2 ">
                                <div class="card-body">
                                    <div>
                                        <span class="fs-6 text-uppercase small fw-semi-bold">Bag Balance</span>
                                    </div>
                                    @php
                                        $balance = App\Models\Jutebag::where(['client_type' => $client_type, 'client_id' => $client_id])->sum('amount');
                                    @endphp

                                    <h2 class="fw-bold {{ ($balance > 0)  ? 'text-success' : 'text-danger' }} mt-0 mb-1">

                                        {{  number_format(abs($balance)) }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card shadow">
                        <!-- Card header -->
                        <div class="card-header fw-bold border-bottom-0 fw-bold">
                            Jute bag legder
                        </div>
                        <!-- Table -->
                        <div class="table-responsive border-0 overflow-y-hidden">
                            <table class="table mb-0 text-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Date </th>
                                        <th class="border-0">Name </th>
                                        <th class="border-0">Particular</th>
                                        <th class="border-0">Inflows</th>
                                        <th class="border-0">Outflows </th>
                                        <th class="border-0">Balance</th>
                                        <th class="border-0">Remark</th>
                                        <th class="border-0">Added By</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bags as $bag)
                                        <tr>
                                            <td class="align-middle">{{ date('j F Y', strtotime($bag->created_at)) }}
                                            </td>
                                            <td class="align-middle">
                                                <a href="/control/jute_ledger?id={{ $bag->client_id }}&&type={{ $bag->client_type }}"
                                                    class="fw-bold">
                                                    {{ $bag->client->name }} ({{ $bag->client_type }})
                                                </a>
                                            </td>
                                            <td class="align-middle">
                                                {{ $bag->action }}
                                            </td>

                                            <td class="align-middle">
                                                @if ($bag->amount > 0)
                                                    <div class="badge badge-success">
                                                        {{ abs($bag->amount) }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                @if ($bag->amount < 0)
                                                    <div class="badge badge-danger">
                                                        {{ abs($bag->amount) }}
                                                    </div>
                                                @endif
                                            </td>

                                            <td class="align-middle">
                                                {{ $bag->balance }}
                                            </td>

                                            <td class="align-middle">
                                                {{ $bag->remark }}
                                            </td>


                                            <td class="align-middle">
                                                {{ $bag->user->name }}
                                            </td>
                                            <td class="align-middle ">

                                                @if (auth()->user()->id == $bag->added_by)
                                                    <a href="/control/delete-bag/{{ $bag->id }}"
                                                        onclick="return confirm('This transaction will be deleted')"
                                                        class="mr-2 btn-danger shadow text-white px-2"> <i
                                                            class="fa fa-trash"></i> </a>
                                                @endif


                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="nav d-flex mt-3 justify-content-end ">
                        {{ $bags->links('pagination::bootstrap-4') }}
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
