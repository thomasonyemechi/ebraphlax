@extends('layouts.app')
@section('page_title')
    Staff Management
@endsection

@section('page_content')
    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Staff</a></li>
                            <li class="breadcrumb-item active">Manage Staff</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-0 fw-bold card-title mb-3">Personal Details</h5>

                            <form action="/control/add_staff" method="post"> @csrf
                                <div class="row">
                                    <div class="col-xl-6 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label text-primary">Full Name<span
                                                    class="required">*</span></label>
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                class="form-control" placeholder="James">
                                                     @error('name')
                                    <i class="text-danger small" > {{$message}} </i>
                                    @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label text-primary">Email<span
                                                    class="required">*</span></label>
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                class="form-control" placeholder="hello@example.com">
                                                     @error('email')
                                    <i class="text-danger small" > {{$message}} </i>
                                    @enderror
                                        </div>


                                    </div>
                                    <div class="col-xl-6 col-sm-6">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="mb-3">
                                                    <label class="form-label text-primary">Staff
                                                        Role<span class="required">*</span></label>
                                                    <select name="role" class="form-control">
                                                        <option value="store-keeper">Store Keeper</option>
                                                        <option>Administrator</option>
                                                        <option>Accountant</option>
                                                    </select>
                                                         @error('role')
                                    <i class="text-danger small" > {{$message}} </i>
                                    @enderror
                                                </div>

                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label text-primary">Phone
                                                Number<span class="required">*</span></label>
                                            <input type="number" name="phone" value="{{ old('phone') }}"
                                                class="form-control" placeholder="+123456789">
                                                     @error('phone')
                                    <i class="text-danger small" > {{$message}} </i>
                                    @enderror
                                        </div>

                                    </div>



                                <div class="col-md-4" >
                                    <label for="">Bank Name <span class="error">*</span></label>
                                    <input type="text" name="bank" value="{{ old('bank') }}" required="required"
                                    class="form-control">
                                    @error('bank')
                                    <i class="text-danger small" > {{$message}} </i>
                                    @enderror
                                </div>


                                <div class="col-md-4" >
                                    <label for="">Account Number <span class="error">*</span></label>
                                    <input type="text" name="bank_account" value="{{ old('bank_account') }}" required="required"
                                    class="form-control">
                                    @error('bank_account')
                                    <i class="text-danger small" > {{$message}} </i>
                                    @enderror
                                </div>


                                <div class="col-md-4" >
                                    <label for="">Account Name <span class="error">*</span></label>
                                    <input type="text" name="account_name" value="{{ old('account_name') }}" required="required"
                                    class="form-control">
                                    @error('account_name')
                                    <i class="text-danger small" > {{$message}} </i>
                                    @enderror
                                </div>
                                




                                    <div class="col-xl-12 col-sm-12">
                                        <label class="form-label text-primary">House Address<span class="required">*</span></label>
                                        <textarea name="address" class="form-control" rows="2"> {{ old('address') }} </textarea>
                                             @error('address')
                                    <i class="text-danger small" > {{$message}} </i>
                                    @enderror
                                    </div>
                                    <div class="col-xl-12 col-sm-6">
                                        <div class="d-flex mt-3 justify-content-end ">
                                            <button class="btn btn-sm btn-primary">Save Details</button>
                                        </div>
                                    </div>
                                </div>
                            </form> 
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12" >
                            <h4 class="fw-bold card-title" >Staff List </h4>
                            <p></p>
                        </div>
                        @foreach ($staffs as $staff)
                            <div class="col-xl-4 col-lg-4 col-sm-6">
                                <div class="card shadow text-center">
                                    <div class="card-body">
                                        <div class="user-content">
                                            <div class="user-info">
                                                <div class="user-img">
                                                    <img src="{{ Avatar::create($staff->name)->toBase64() }}"
                                                        class="rounded-circle " style="width: 50px" />
                                                </div>
                                                <div class="user-details mt-2">
                                                    <h4 class="user-name fw-bold fs-6 mb-0">{{ $staff->name }}</h4>
                                                    <p>{{ $staff->role }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" d-flex justify-content-center text-white  mb-2 mt-0">
                                            <span class="badge bg-success mr-2 light">{{ $staff->phone }}</span>
                                            <span
                                                class="badge bg-danger light">{{ date('j M, Y', strtotime($staff->created_at)) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-center ">
                                            <a href="#" class="btn-info shadow mt-2 btn-sm w-50"><i
                                                    class="fa fa-user me-2"></i>Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="nav d-flex mt-3 justify-content-end ">
                        {{ $staffs->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    @endsection
