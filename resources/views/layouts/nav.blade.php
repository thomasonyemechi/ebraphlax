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
                <li class="menu-title">Main</li>
                <li>
                    <a href="/control/dashboard" class="">
                        <i class="flaticon-dashboard"></i><span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title">Admin Functions</li>



                @if ($role == 'administrator')
                    <li>
                        <a href="#" class=""><i class="flaticon-new-product"></i><span>
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
                        <a class="" href="/control/manage-permission" class="">
                            <i class="flaticon-bill"></i><span>Manage Permisions </span>
                        </a>
                    </li>
                @endif




                <li class="menu-title">Store Management</li>


                @if ($mis->manage_staff)
                    <li class="">
                        <a class="" href="/control/staffs" class="">
                            <i class="flaticon-bill"></i><span> Manage Staff </span>
                        </a>
                    </li>
                @endif


                @if ($mis->cost_analysis)
                    <li class="">
                        <a class="" href="/control/pos" class="">
                            <i class="flaticon-bill"></i><span> Cost Analysis </span>
                        </a>
                    </li>



                    <li>
                        <a href="#" class=""><i class="flaticon-expenses"></i><span>
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
                                <a href="/control/expense">Manage Expense</a>
                            </li>
                        </ul>
                    </li>
                @endif



                @if ($mis->manage_customer)
                    <li>
                        <a href="#" class=""><i class="flaticon-new-product"></i><span>
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
                        </ul>
                    </li>
                @endif

                @if ($mis->jute_bag)
                    <li class="">
                        <a class="" href="/control/jute-bags" class="">
                            <i class="flaticon-bill"></i><span> Jute Bags </span>
                        </a>
                    </li>
                @endif


                @if ($mis->visit_log)
                    <li class="">
                        <a class="" href="/control/visitors" class="">
                            <i class="flaticon-bill"></i><span> Visitor's Log </span>
                        </a>
                    </li>
                @endif



                @if ($mis->manage_stock)
                    <li class="">
                        <a class="" href="/control/manage-stock" class="">
                            <i class="flaticon-bill"></i><span> Manage Stock </span>
                        </a>
                    </li>
                @endif



                @if ($mis->manage_customer)
                    <li>
                        <a href="#" class=""><i class="flaticon-new-product"></i><span>
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
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
