@extends('layouts.app')
@section('page_title')
    Expenses Overview
@endsection

@section('page_content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Expenses</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Expenses</a></li>
                            <li class="breadcrumb-item active">Add Expense</li>
                        </ol>
                    </div>
                    <div class="col-sm-3 offset-3">
                        <div class="d-flex justify-content-end">
                            <a href="/control/expense_overview" class="btn btn-primary">Expenses Overview</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col-md-12">

                    <div class="card mb-3 shadow">
                        <div class="card-body">
                            <div class="d-flex mb-3 justify-content-between">
                                <h4 class="fw-bold card-title">Add Expenses</h4>
                                <button class="btn btn-secondary add_category py-0 btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#add_item">Create Expense Category</button>
                            </div>
                            <form action="/admin/create-expenses" method="post"> @csrf
                                <div class="row">
                                    <div class="col-xl-6 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Expenses Category</label>
                                            <select name="category_id" class="form-control">
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}"> {{ $cat->title }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label class="form-label ">Amount<span class="required">*</span></label>
                                            <input type="number" name="amount" value="{{ old('amount') }}"
                                                class="form-control" placeholder="300000">
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label class="form-label ">Assign Customer or Supplier<span
                                                    class="required">*</span></label>

                                            <select name="" class="form-control" id="">

                                                @foreach ($all_client as $client)
                                                    <option value="{{ json_encode($client) }}"> {{ $client['name'] }} |
                                                        {{ $client['role'] }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-sm-12">
                                        <div class="mb-3">
                                            <label for="">Remark</label>
                                            <textarea name="remark" class="form-control" cols="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-sm-6">
                                        <div class="d-flex justify-content-end ">
                                            <button class="btn btn-primary">Save Expenses</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="card shadow">
                        <!-- Card header -->
                        <div class="card-header fw-bold border-bottom-0 fw-bold">
                            All Expenses
                        </div>
                        <!-- Table -->
                        <div class="table-responsive border-0 overflow-y-hidden">
                            <table class="table mb-0 text-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Expense </th>
                                        <th class="border-0">Amount</th>
                                        <th class="border-0">Remark</th>
                                        <th class="border-0">Add By </th>
                                        <th class="border-0">Date</th>
                                        <th class="border-0"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($expenses as $expense)
                                        <tr>
                                            <td class="align-middle border-top-0">
                                                <a href="#" class="text-inherit position-relative">
                                                    <h5 class="mb-0 fw-bold text-primary-hover">
                                                        {{ $expense->category->title }}
                                                    </h5>
                                                </a>
                                            </td>
                                            <td class="align-middle border-taop-0">
                                                {{ money($expense->amount) }}
                                            </td>
                                            <td class="align-middle border-top-0">{{ $expense->remark }}</td>
                                            <td class="align-middle border-top-0">
                                                {{ $expense->user->name }}
                                            </td>
                                            <td class="align-middle border-top-0">
                                                {{ $expense->created_at }}
                                            </td>
                                            <td class="align-middle border-top-0">
                                                <div class="d-flex justify-content-end ">
                                                    <a class="text-danger"> <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <div class="modal fade" id="add_category" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title m-0" id="exampleModalLongTitle"> Create Expenses Cateogry </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form method="POST" class="row" action="/control/create-expenses-category">
                        @csrf

                        <div class="col-lg-12 mb-2 ">
                            <div class="alert mb-2 w-100 alert-warning">
                                Fill the form below to add new expenses category
                            </div>
                            <label class="form-label">Expenses Category Name<span class="text-danger">*</span></label>
                            <input type="text" name="category_name" class="form-control " placeholder="Category Name"
                                required autocomplete="zpo">
                        </div>

                        <div class="col-lg-12 mb-3 mb-3 mt-2">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>

                            <div class="d-flex mt-2 justify-content-end">
                                <button type="submit" class="btn py-2 btn-primary">Save Category</button>
                            </div>
                        </div>

                    </form>
                    <div class="card shadow border-1">
                        <div class="table-responsive mt-3 border-0 overflow-y-hidden">

                            <table class="table mb-0 text-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Category </th>
                                        <th class="border-0">Description</th>
                                        <th class="border-0"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $cat)
                                        <tr>
                                            <td> {{ $cat->title }} </td>
                                            <td> {{ $cat->description }} </td>
                                            <td>
                                                <div class="d-flex justify-content-end ">
                                                    <a class="text-danger"
                                                        href="/control/delete_expenses_category/{{ $cat->id }}"> <i
                                                            class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(function() {
            $('.add_category').on('click', function() {
                $('#add_category').modal('show')
            })
        })
    </script>
@endpush
