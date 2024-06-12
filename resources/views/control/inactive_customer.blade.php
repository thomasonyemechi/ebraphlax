@extends('layouts.app')
@section('page_title')
    Inactive Supplier
@endsection

@section('page_content')
    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Inactive Suppliers</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Supplier</a></li>
                            <li class="breadcrumb-item active">Inactive Supplier</li>
                        </ol>
                    </div>
                    <div class="col-sm-3 offset-3">
                        <form action="">
                            <div class="d-flex justify-content-end ">


                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">


                            <div class="row">

                                @isset($_GET['supplier'])
                                    <div class="col-md-12">
                                        <div class="alert mb-3 alert-info">
                                            <h5 class="fw-bold">These are the search results for "{{ $_GET['supplier'] }}"</h5>
                                            you can search based on supplier name, nick name, company, phone number and address
                                        </div>
                                    </div>
                                @endisset
                                <div class="table-responsive">


                                    <table class="table table-bordered tabel-striped ">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Joined</th>
                                                <th>Last Transaction</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($suppliers as $sup)
                                                @php
                                                    $limit = 86400 * 30;
                                                    $last_time = time() - strtotime($sup->last_trno);
                                                @endphp


                                                @if ($last_time > $limit)
                                                    <tr>
                                                        <td> <a href="/control/supplier/{{ $sup->id }}"
                                                                class="fw-bold">{{ $sup->name }} </a> </td>
                                                        <td> {{ $sup->phone }} </td>
                                                        <td> {{ $sup->address }} </td>
                                                        <td> {{ date('j F Y', strtotime($sup->created_at)) }} </td>
                                                        <td>
                                                            {{ ($sup->last_trno == 'notime') ? `Dormant Profile` : date('j F, Y',strtotime($sup->last_trno)) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>

                            </div>
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
