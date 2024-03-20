@extends('layouts.app')
@section('page_title')
    Manage Permission
@endsection

@section('page_content')
    <div class="content">
        <div id="app" class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Manage Permission</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">Users</a></li>
                            <li class="breadcrumb-item active">Permission</li>
                        </ol>
                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">

                            <form method="post" action="/control/update-permission">

                                @csrf
                                <input type="hidden" name="all_users"
                                    value="{{ json_encode($users->pluck('id')->toArray()) }}">
                                <div class="table-responsive border-0 overflow-y-hidden">
                                    <table class="table mb-0 text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Staff name</th>
                                                <th>Jute Bags</th>
                                                <th>Cost Analy</th>
                                                <th>Staff</th>
                                                <th>Customer</th>
                                                <th>Expenses</th>
                                                <th>Ledger</th>
                                                <th>Stock</th>
                                                <th>Visit Log</th>
                                                <th>Transcript</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="">

                                            @foreach ($users as $user)
                                                @php
                                                    $per = $user->permission;

                                                    // print_r($per); exit;

                                                @endphp
                                                <tr class="single">
                                                    <td class="align-middle"> {{ $user->name }} ({{ $user->role }})
                                                    </td>

                                                    <td class="text-center">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" name="jute_bag{{ $user->id }}"
                                                                value="{{ $per->jute_bag ?? 0 == 1 ? 1 : 0 }}"
                                                                {{ $per->jute_bag == 1 ? 'checked' : '' }}>
                                                            <label for="jute_bag{{ $user->id }}"></label>
                                                        </div>
                                                    </td>


                                                    <td class="text-center">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" name="cost_analysis{{ $user->id }}"
                                                                value="{{ $per->cost_analysis ?? 0 == 1 ? 1 : 0 }}"
                                                                {{ $per->cost_analysis == 1 ? 'checked' : '' }}>
                                                            <label for="cost_analysis{{ $user->id }}"></label>
                                                        </div>
                                                    </td>

                                                    <td class="text-center">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" name="manage_staff{{ $user->id }}"
                                                                value="{{ $per->manage_staff ?? 0 == 1 ? 1 : 0 }}"
                                                                {{ $per->manage_staff == 1 ? 'checked' : '' }}>
                                                            <label for="manage_staff{{ $user->id }}"></label>
                                                        </div>
                                                    </td>


                                                    <td class="text-center">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox"
                                                                name="manage_customer{{ $user->id }}"
                                                                value="{{ $per->manage_customer ?? 0 == 1 ? 1 : 0 }}"
                                                                {{ $per->manage_customer == 1 ? 'checked' : '' }}>
                                                            <label for="manage_customer{{ $user->id }}"></label>
                                                        </div>
                                                    </td>


                                                    <td class="text-center">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox"
                                                                name="manage_expenses{{ $user->id }}"
                                                                value="{{ $per->manage_expenses ?? 0 == 1 ? 1 : 0 }}"
                                                                {{ $per->manage_expenses == 1 ? 'checked' : '' }}>
                                                            <label for="manage_expenses{{ $user->id }}"></label>
                                                        </div>
                                                    </td>


                                                    <td class="text-center">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" name="check_ledger{{ $user->id }}"
                                                                value="{{ $per->check_ledger ?? 0 == 1 ? 1 : 0 }}"
                                                                {{ $per->check_ledger == 1 ? 'checked' : '' }}>
                                                            <label for="check_ledger{{ $user->id }}"></label>
                                                        </div>
                                                    </td>


                                                    <td class="text-center">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" name="manage_stock{{ $user->id }}"
                                                                value="{{ $per->manage_stock ?? 0 == 1 ? 1 : 0 }}"
                                                                {{ $per->manage_stock == 1 ? 'checked' : '' }}>
                                                            <label for="manage_stock{{ $user->id }}"></label>
                                                        </div>
                                                    </td>


                                                    <td class="text-center">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" name="visit_log{{ $user->id }}"
                                                                value="{{ $per->visit_log ?? 0 == 1 ? 1 : 0 }}"
                                                                {{ $per->visit_log == 1 ? 'checked' : '' }}>
                                                            <label for="visit_log{{ $user->id }}"></label>
                                                        </div>
                                                    </td>



                                                    <td class="text-center">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox"
                                                                name="business_detial{{ $user->id }}"
                                                                value="{{ $per->business_detial ?? 0 == 1 ? 1 : 0 }}"
                                                                {{ $per->business_detial == 1 ? 'checked' : '' }}>
                                                            <label for="business_detial{{ $user->id }}"></label>
                                                        </div>
                                                    </td>



                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-warning mr-2"
                                        onclick="return confirm('All permission will be updated based on users initial role ' )">
                                        <i class="fa fa-eraser"></i>
                                        Reset Permission </button>
                                    <button class="btn btn-primary"> <i class="fa fa-save"></i> Save Permission </button>
                                </div>
                            </form>
                        </div>

                    </div>


                    <div class="nav d-flex mt-3 justify-content-end ">
                        {{ $users->links('pagination::bootstrap-4') }}
                    </div>

                </div>



            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(function() {
            $('body').on('click', 'input', function() {
                inp = $(this);
                new_val = (inp.val() == 0) ? 1 : 0;
                inp.val(new_val);
            })
        })
    </script>
@endpush
