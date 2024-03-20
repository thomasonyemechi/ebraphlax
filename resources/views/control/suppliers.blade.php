@extends('layouts.app')
@section('page_title')
    Supplier Info
@endsection

@section('page_content')
    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Supplier</a></li>
                            <li class="breadcrumb-item active">Manage Supplier</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Add Supplier</h4>
                            <form action="/control/add_supplier" method="POST" class="form-validate">@csrf

                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="">Full Name <span class="error">*</span></label> 
                                        <input
                                            type="text" name="name" value="{{ old('name') }}" required="required"
                                            class="form-control">

                                        @error('name')
                                            <i class="text-danger small"> {{ $message }} </i>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="">Company Name <span class="error">*</span></label>
                                        <input type="text" name="company_name" value="{{ old('company_name') }}" required="required"
                                            class="form-control">
                                        @error('company_name')
                                            <i class="text-danger small"> {{ $message }} </i>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="">Nick Name <span class="error">*</span></label>
                                        <input type="text" name="nick_name" value="{{ old('nick_name') }}" required="required"
                                            class="form-control">
                                            @error('nick_name')
                                            <i class="text-danger small" > {{$message}} </i>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Email <span class="error">*</span></label>
                                        <input type="email" name="email" value="{{ old('email') }}" required="required"
                                            class="form-control">
                                            @error('email')
                                            <i class="text-danger small" > {{$message}} </i>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6"><label for="">Phone <span
                                                class="error">*</span></label>
                                        <input type="tel" name="phone" value="{{ old('phone') }}" required="required"
                                            class="form-control">
                                            @error('phone')
                                            <i class="text-danger small" > {{$message}} </i>
                                        @enderror
                                    </div>


                                    <div class="col-sm-12"><label for="" class="text-muted">Address</label>
                                        <div class="row">
                                            <div class="form-group col-sm-12"><label for="short_address">Short
                                                    address <small>(if you are not fill up this above address then you
                                                        can fill this short address)</small></label>
                                                <textarea name="address" id="short_address" placeholder="Short address" class="form-control">{{ old('address') }}</textarea>
                                                @error('address')
                                                <i class="text-danger small" > {{$message}} </i>
                                            @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="d-flex  justify-content-end">
                                        <button type="submit" class="btn btn-primary btn-lg waves-effect waves-lightml-2">
                                            <i class="fa fa-save"></i> <span>Submit</span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>




                </div>



            </div>
        </div>
    </div>
@endsection
