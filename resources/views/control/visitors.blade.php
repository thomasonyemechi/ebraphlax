@extends('layouts.app')
@section('page_title')
    Manage visitors
@endsection

@section('page_content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Manage visitors</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Control</a></li>
                            <li class="breadcrumb-item active">Manage visit</li>
                        </ol>
                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col-md-12">

                    <div class="card mb-3 shadow">
                        <div class="card-body">
                            <div class="d-flex mb-3 justify-content-between">
                                <h4 class="fw-bold card-title">Register Visit</h4>
                            </div>
                            <form action="/control/add-visit" method="post"> @csrf
                                <div class="row">

                                    <div class="col-xl-12">
                                        <div class="mb-3">
                                            <label class="form-label ">Client Name<span class="required">*</span></label>
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                class="form-control" placeholder="Please enter client name here">
                                            @error('name')
                                                <i class="text-danger small"> {{$message}} </i>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-xl-12 col-sm-12">
                                        <div class="mb-3">
                                            <label for="">Reason for Visit</label>
                                            <textarea name="reason" class="form-control" placeholder="Enter reason and detials of client visit" cols="2">{{ old('reason') }}</textarea>
                                            @error('reason')
                                            <i class="text-danger small"> {{$message}} </i>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-sm-6">
                                        <div class="d-flex justify-content-end ">
                                            <button class="btn btn-primary">Submit </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="card shadow">
                        <!-- Card header -->
                        <div class="card-header fw-bold border-bottom-0 fw-bold">
                            All Visits
                        </div>
                        <!-- Table -->
                        <div class="table-responsive border-0 overflow-y-hidden">
                            <table class="table mb-0 text-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Name </th>
                                        <th class="border-0">Reason For Visit</th>
                                        <th class="border-0">Time In</th>
                                        <th class="border-0">Time Out </th>
                                        <th class="border-0">Date</th>
                                        <th class="border-0">Added By</th>
                                        <th class="border-0"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visitors as $visit)
                                        <tr>
                                            <td class="align-middle">
                                                        {{ $visit->name }}
                                            </td>
                                            <td class="align-middle" style="white-space: wrap">
                                                {{ $visit->reason }}
                                            </td>
                                            <td class="align-middle">{{ date('h:i a', $visit->time_in) }}</td>
                                            <td class="align-middle">{{ ($visit->time_out) ? date('h:i a', $visit->time_out)  : '' }}</td>
                                            <td class="align-middle">{{ date( 'j F Y' , strtotime($visit->created_at)) }}</td>
                                            <td class="align-middle">
                                                {{ $visit->user->name }}
                                    </td>
                                            <td class="align-middle ">
                                                <div class="d-flex justify-content-end ">
                                                    <a href="/control/update-timeout/{{$visit->id}}" class="mr-2 btn-light shadow text-info px-2"> Time out </a>
                                                    {{-- <a class="mr-2 btn-primary shadow text-white px-2"> <i class="fa fa-edit"></i> </a> --}}
                                                    <a href="/control/delete-visit/{{$visit->id}}" class="mr-2 btn-danger shadow text-white px-2"> <i class="fa fa-trash"></i> </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    
                    <div class="nav d-flex mt-3 justify-content-end ">
                        {{ $visitors->links('pagination::bootstrap-4') }}
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
