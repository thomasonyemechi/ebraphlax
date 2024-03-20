@extends('layouts.app')
@section('page_title')
    Manage Bags
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
                            <li class="breadcrumb-item active">Manage Jute Bags</li>
                        </ol>
                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col-md-12">

                    <div class="card mb-3 shadow">
                        <div class="card-body">
                            <div class="d-flex mb-3 justify-content-between">
                                <h4 class="fw-bold card-title">Manage Bags</h4>
                            </div>
                            <form action="/control/add-jutebags" method="post"> @csrf
                                <div class="row">

                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label class="form-label ">Client Name<span class="required">*</span></label>
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                class="form-control" placeholder="Please enter client name here">
                                            @error('name')
                                                <i class="text-danger small"> {{ $message }} </i>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label class="form-label ">Select Action<span class="required">*</span></label>
                                            <select name="action" class="form-control" id="">
                                                <option>store use</option>
                                                <option>advance</option>
                                                <option>purchased</option>
                                                <option>return</option>
                                            </select>
                                            @error('name')
                                                <i class="text-danger small"> {{ $message }} </i>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label class="form-label ">Total Bags<span class="required">*</span></label>
                                            <input type="text" name="bags" value="{{ old('bag') }}"
                                                class="form-control" placeholder="Enter Bag Amount">
                                            @error('bags')
                                                <i class="text-danger small"> {{ $message }} </i>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-xl-3 offset-md-6 ">
                                        <div class="mb-3">
                                            <input type="text" name="remark" value="{{ old('remark') }}"
                                                class="form-control" placeholder="Enter addtional note">
                                            @error('remark')
                                                <i class="text-danger small"> {{ $message }} </i>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-xl-3">
                                        <div class="d-flex justify-content-end ">
                                            <button class="btn btn-block btn-primary">Submit Jute bag Transaction </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
                                                {{ $bag->name }}
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
                                                <a href="/control/delete-bag/{{ $bag->id }}"
                                                    onclick="return confirm('This transaction will be deleted')"
                                                    class="mr-2 btn-danger shadow text-white px-2"> <i
                                                        class="fa fa-trash"></i> </a>
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
