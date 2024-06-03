@php
    $mis = auth()->user()->permission;
    if (!$mis) {
        abort('404');
    }
    $role = auth()->user()->role;
@endphp

<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">
        <!--- Side Menu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">

                @if (auth()->user()->warehouse_id == 1)
                    <li class="menu-title">Main</li>
                    <li>
                        <a href="/control/dashboard" class=""><span> Dashboard </span>
                        </a>
                    </li>
                @endif


                @if ($role == 'administrator')
                    <li class="menu-title">Admin Functions</li>


                    <li>
                        <a href="#" class=""><span>
                                Product
                                <span class="float-right menu-arrow">
                                    <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="10 15 15 20 20 15"></polyline>
                                        <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                    </svg>
                                </span>
                            </span></a>
                        <ul class="submenu">
                            <li class=""><a href="/control/products">Product</a>
                            </li>
                        </ul>
                    </li>


                    <li class="">
                        <a class="" href="/control/manage-permission" class=""><span>Manage Permisions
                            </span>
                        </a>
                    </li>
                @endif




                <li class="menu-title">Store Management</li>



                @if ($mis->cost_analysis)
                    <li>
                        <a href="#" class=""><span>
                                Today Info
                                <span class="float-right menu-arrow">
                                    <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="10 15 15 20 20 15"></polyline>
                                        <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                    </svg>
                                </span>
                            </span></a>
                        <ul class="submenu">
                            <li>
                                <a href="/control/today/{{ auth()->user()->id }}">Overview </a>
                            </li>

                            <li>
                                <a href="/control/today-export">Export</a>
                            </li>
                        </ul>
                    </li>

                    <li class="">
                        <a class="" href="/control/all-exported" class="">
                            <span>All Exported Goods </span>
                        </a>
                    </li>
                @endif



                @if ($mis->manage_staff)
                    <li class="">
                        <a class="" href="/control/staffs" class="">
                            <span> Manage Staff </span>
                        </a>
                    </li>
                @endif


                @if ($mis->manage_stock)
                    <li class="">
                        <a class="" href="/control/stock" class="">
                            <span> Stock </span>
                        </a>
                    </li>
                @endif


                @if ($mis->business_detial)
                <li class="">
                    <a class="" href="/control/branch_stock" class="">
                        <span> All Branch Stock </span>
                    </a>
                </li>
            @endif

                @if ($mis->cost_analysis)
                    <li class="">
                        <a class="" href="/control/manage-stock" class="">
                            <span> Manage Stock </span>
                        </a>
                    </li>


                    <li class="">
                        <a class="" href="/control/pos" class="">
                            <span> Cost Analysis </span>
                        </a>
                    </li>



                    <li>
                        <a href="#" class="">
                            <span>
                                Expenses
                                <span class="float-right menu-arrow">
                                    <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="10 15 15 20 20 15"></polyline>
                                        <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                    </svg>
                                </span>
                            </span></a>
                        <ul class="submenu">
                            <li>
                                <a href="/control/expense_overview">Overview </a>
                            </li>
                            <li>
                                <a href="/control/expenses">Manage Expense</a>
                            </li>
                        </ul>
                    </li>
                @endif


                @if ($mis->manage_customer)
                    <li>
                        <a href="#" class=""><span>
                                Manage Importers
                                <span class="float-right menu-arrow">
                                    <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="10 15 15 20 20 15"></polyline>
                                        <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                    </svg>
                                </span>
                            </span></a>
                        <ul class="submenu">
                            <li class=""><a href="/control/suppliers">Add Supplier</a>
                            </li>
                            <li class=""><a href="/control/supplier/all">All Suppliers</a>
                            </li>
                            <li class=""><a href="/control/suppliers/balance">Suppliers Balance</a>
                            </li>
                            <li class=""><a href="/control/suppliers/account">Bank Details</a>
                            </li>

                            <li class=""><a href="javascript::">Inactive Supplier </a>
                            </li>
                        </ul>
                    </li>
                @endif






                @if ($mis->manage_customer)
                    <li class="">
                        <a class="" href="/control/make_export_ledger" class="">
                            <span> Make Export </span>
                        </a>
                    </li>


                    <li>
                        <a href="#" class=""><span>
                                Exporters
                                <span class="float-right menu-arrow">
                                    <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="10 15 15 20 20 15"></polyline>
                                        <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                    </svg>
                                </span>
                            </span></a>
                        <ul class="submenu">
                            <li class=""><a href="/control/add_customer">Add Exporters</a>
                            </li>
                            <li class=""><a href="/control/customers">Exporter's List </a>
                            </li>
                            <li class=""><a href="/control/customers/balance">Exporters Balance </a>
                            </li>

                            <li class=""><a href="javascript:;">Inactive Exporters </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if ($mis->jute_bag)
                    <li class="">
                        <a class="" href="/control/jute-bags" class="">
                            <span> Jute Bags </span>
                        </a>
                    </li>
                @endif


                @if ($mis->visit_log)
                    <li class="">
                        <a class="" href="/control/visitors" class="">
                            <span> Visitor's Log </span>
                        </a>
                    </li>
                @endif



                @if ($role == 'administrator')
                    <li>
                        <a href="#" class=""><span>
                                Business Report
                                <span class="float-right menu-arrow">
                                    <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="10 15 15 20 20 15"></polyline>
                                        <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                    </svg>
                                </span>
                            </span></a>
                        <ul class="submenu">
                            <li class=""><a href="/control/daily_report">Daily Report</a>
                            </li>
                            <li class=""><a href="/control/wekly_report">Weekly Report </a>
                            </li>
                            <li class=""><a href="/control/wekly_report">Monthly Report </a>
                            </li>
                            <li class=""><a href="/control/wekly_report">Yearly Report </a>
                            </li>
                            <li class=""><a href="/control/wekly_report">Report accross Date </a>
                            </li>
                        </ul>
                    </li>
                @endif


      




            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>

</div>
