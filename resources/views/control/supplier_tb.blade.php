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
                                        placeholder="Enter importer's name and click enter" style="width: 150px !important;"
                                        value="{{ $_GET['supplier'] ?? '' }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">

<div class="card" >
    <div class="card-body" >


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


                <table class="table table-sm ">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $sup)
                            <tr>
                                <td> {{ $sup->name }} </td>
                                <td> {{ $sup->phone }} </td>
                                <td> {{ $sup->address }} </td>
                                <td> {{ $sup->created_at }} </td>
                            </tr>
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
