@extends('layouts.app')
@section('page_title')
    Manage Supplier
@endsection

@section('page_content')
    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Suppliers / Importers</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Supplier</a></li>
                            <li class="breadcrumb-item active">All Supplier</li>
                        </ol>
                    </div>
                    <div class="col-sm-3 offset-3">
                        <form action="">
                            <div class="d-flex justify-content-end ">

                                <div class="input-group mr-3  ">
                                    <input type="search" name="supplier" class="form-control"
                                        placeholder="Enter importer's name and click enter"
                                        style="width: 150px !important;" value="{{$_GET['supplier'] ?? ''}}" >
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">



                    <div class="row">
                        
                        @isset($_GET['supplier'])
                            <div class="col-md-12" >
                                <div class="alert mb-3 alert-info" >
                                    <h5 class="fw-bold" >These are the search results for  "{{ $_GET['supplier'] }}"</h5>
                                    you can search based on supplier name, nick name, company, phone number and address
                                </div>
                            </div>
                        @endisset

                        @foreach ($suppliers as $supplier)
                            <div class="col-xl-4 col-lg-4 col-sm-6">
                                <div class="card shadow text-center">
                                    <div class="card-body">
                                        <div class="user-content">
                                            <div class="user-info">
                                                <div class="user-img">
                                                    <img src="{{ Avatar::create($supplier->name)->toBase64() }}"
                                                        class="rounded-circle " style="width: 50px" />
                                                </div>
                                                <div class="user-details mt-2">
                                                    <h4 class="user-name fw-bold fs-6 mb-0">{{ $supplier->name }}</h4>
                                                    <p>{{ $supplier->nick_name }} ({{ $supplier->company_name }}) </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" d-flex justify-content-center text-white  mb-2 mt-0">
                                            <span class="badge bg-success mr-2 light">{{ $supplier->phone }}</span>
                                            <span
                                                class="badge bg-danger light">{{ date('j M, Y', strtotime($supplier->created_at)) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-center ">
                                            <a href="/control/supplier/{{ $supplier->id }}"
                                                class="btn-secondary shadow mt-2 btn-sm w-50"><i
                                                    class="fa fa-user mr-2"></i>Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <div class="nav d-flex mt-3 justify-content-end ">
                        {{ $suppliers->links('pagination::bootstrap-4') }}
                    </div>


                </div>



            </div>
        </div>
    </div>
@endsection
