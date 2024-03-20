@extends('layouts.app')
@section('page_title')
    Point Of Sales
@endsection




@section('page_content')
    <div class="content">
        <div id="app" class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row mt-3">
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-text py-1 px-2 bg-success fw-bold" id="basic-addon3">I want
                                        to</span>
                                    <select id="action" name="action" class="form-control py-1 px-1">
                                        <option>export</option>
                                        {{-- @if (auth()->user()->role == 'administrator')
                                            <option>import</option>
                                        @endif --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            @include('control.search')

                        </div>

                        <div class="col-md-3">
                            <div class="form-group">

{{-- 
                                <select id="supplier" class="form-control client supplier" style="display: none">
                                    <option selected disabled>Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"> {{ $supplier->name }} <span class="fw-bold"> (
                                                {{ $supplier->nick_name, $supplier->phone }} ) </span> </option>
                                    @endforeach
                                </select> --}}

                                <select id="customer" class="form-control client customer">
                                    <option selected disabled>Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"> {{ $customer->name }} <span class="fw-bold"> (
                                                {{ $customer->nick_name, $customer->phone }} ) </span> </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-5">

                    <div class="alert mt-3 action_alert alert-warning">

                    </div>

                    <div class="card mt-z  all_content ">
                        <div class="card-body p-3 ">

                            <div class="table-responsive">
                                <table class="table table-sm " style="border: 0 !important">
                                    <thead>
                                        <tr>
                                            <th class="text-start" colspan="2">Product</th>
                                            <th>Avail Qty</th>
                                            <th class="text-start">Bags</th>

                                            <th>Gros/wt (kg)</th>
                                            <th>Moisture/dis</th>
                                            <th>Tares</th>
                                            <th>Net/wt (kg)</th>

                                            <th>Price (₦)</th>
                                            <th>Ext Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="cart_list">
                                    </tbody>
                                </table>
                            </div>

                            <div class="total_area">

                            </div>


                        </div>
                    </div>
                    <div>
                        <div class="">
                            <div class=" p-3 d-flex justify-content-end ">
                                <button class="btn btn-danger clear_cart mr-2" data-trno="{{ $_GET['trno'] }}"> <i
                                        class="fa fa-ban"></i> Cancel</button>
                                {{-- <button class="btn btn-success btn-lg checkout-only mr-2"> <i class="fa fa-save"></i> Save
                                    Only</button> --}}
                                <button class="btn btn-primary checkout"> <i class="fa fa-print"></i> Save and
                                    Print</button>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="col-md-12">
                    <div class="card shadow mt-3 ">
                        <div class="card-body">
                            <h3 class="card-title mb-3">Available Stocks</h3>
                            <div class="table-responsive" >
                                <table class="table table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Commodity</th>

                                            <th>Client</th>
                                            <th>Bags</th>
                                            <th>Gross/Weight</th>
                                            <th>Tares</th>
                                            <th>Mositure <br> Discount</th>
                                            <th>Net weight</th>
                                            <th>Price</th>
                                            <th>Amount</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($available_stock as $stock)
                                            <tr>
                                                <td>{{$stock->client->name}}</td>
                                                <td>{{$stock->product->name}}</td>
                                                <td>{{$stock->bags}}</td>
                                                <td>{{number_format($stock->net_weight)}}</td>
                                                <td></td>
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
    </div>
@endsection


@push('scripts')
    <script>
        $(function() {


            function trno() {
                return Math.floor(Math.random() * 10000000000000000);
            }

            const money_format = (num) => {
                var numb = new Intl.NumberFormat();
                return '₦ ' + numb.format(num);
            }

            const number_format = (num) => {
                var numb = new Intl.NumberFormat();
                return numb.format(num);
            }

            trno = `<?= $_GET['trno'] ?>`;

            function getItems() {
                items = (localStorage.getItem(trno) == null) ? [] : JSON.parse(localStorage.getItem(trno));
                return items;
            }

            function setItem(trno, items) {
                localStorage.setItem(trno, JSON.stringify(items));
            }

            // function calculatePrice(gross_weight, discount, bags) {
            //     return gross_weight - (discount + (bags * 1.5))
            // }

            function calculateNetWeight(gross_weight, discount, bags, type = 1) {

                if (type == 2) {
                    console.log('type is 222');
                    return (gross_weight / 1027);
                } else {
                    return gross_weight - (discount + (bags * 1.5))
                }
            }

            function displayCart() {
                items = getItems();
                expenses = (localStorage.getItem('expenses') == null) ? [] : JSON.parse(localStorage.getItem(
                    'expenses'));
                card = $('.cart_list');
                card.html(``);

                if (items == null || items.length == 0) {
                    $('.all_content').hide();
                    return;
                }
                $('.all_content').show();

                cart_total = 0;

                total_qty = 0;
                total_net_weight = 0;

                items.map((item, index) => {

                    total_qty += parseInt(item.bags);
                    tares = (item.bags) * 1.5;
                    net_weight = calculateNetWeight(item.gross_weight, item.moisture_discount, item.bags,
                        item.type);
                    total_net_weight += net_weight;
                    total = net_weight * item.price;
                    cart_total += parseInt(total)

                    card.append(`

                        <tr>
                            <td colspan="2" ><span class="fw-bold " >${item.name}</span></td>
                            <td><span>${(item.quantity > 0) ? item.quantity : 0 }</span></td>
                            <td><input type="number" class="bags form-control px-2 me-2 py-0 p-0" min="1" step="any" value="${item.bags}" data-index=${item.uuid} style="width:60px"></td>
                            <td><input type="number" class="gross_weight form-control px-2 me-2 py-0 p-0" min="1" value="${item.gross_weight}" data-index=${item.uuid} style="width:100px"></td>
                            <td><input type="number" class="moisture_discount form-control px-2 me-2 py-0 p-0" min="0" step="any" value="${item.moisture_discount}" data-index=${item.uuid} style="width:60px"></td>
                            <td><span class="final_weight" >${tares.toFixed(2)}</span></td>
                            <td><input type="number" class=" form-control px-2 me-2 py-0 p-0" min="1" step="any" readonly value="${net_weight.toFixed(2)}" data-index=${item.uuid} style="width:100px"></td>
                            <td><input type="number" class="cart_price form-control px-2 me-2 py-0 p-0" min="1" value="${item.price}" data-index=${item.uuid} style="width:80px"></td>
                            <td>
                                <span>${money_format(total)}</span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-end" >
                                    <a href="javascript:;" class="remove_item mt-1 text-danger fs-4 fw-bolder " data-uuid=${item.uuid} >
                                        <i class="fa fa-minus-circle"></i>
                                    </a> 
                                </div>      
                            </td>
                        </tr>
                    `)
                })


                string = '';
                total_expenses = 0;
                // loop for expenses
                expenses.map((expense, index) => {
                    total_expenses += parseInt(expense.amount);
                    string += `

                        <tr>
                            <td>${expense.title}</td>
                            <td>${money_format(expense.amount)}</td>
                            <td>
                                <div class="d-flex justify-content-end" >
                                    <a href="javascript:;" class="remove_expense mt-1 text-danger fs-4 fw-bolder " data-uuid=${expense.uuid} >
                                        <i class="fa fa-minus-circle"></i>
                                    </a> 
                                </div>       
                            </td>
                        </tr>
                    
                    `
                })


                action = $('#action').val();


                lorry = (action == 'export') ? `
                    <div class="col-md-12 mt-3" >
                        <div class="form-group" >
                            <label>Lorry Number</label>
                            <input type="text" class="form-control lorry_number" id="lorry_number"  placeholder="Lorry Number">
                        </div>    
                    </div>
                ` : '';

                $('.total_area').html(`
                    <div class="row sales_sum mt-2 px-2 py-3 ">
                        <div class="col-md-6">
                            <div class="card shadow" style="height : 350px; overflow-y: scroll" >
                                <div class="card-body">
                                    <big class="mb-2">Add expenses incured</big>
                                    <div class="row">
                                        <div class="col-4">
                                            <input type="text" class="form-control expense_title" placeholder="Expenses">
                                        </div>
                                        <div class="col-4">
                                            <input type="number" class="form-control expense_amount" placeholder="Amount">
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-primary w-100 add_expense">Add</button>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive mt-3">
                                                <table class="table table-sm " style="border: 0 !important">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-start" >Title</th>
                                                            <th>Amount</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                      ${string}
                                                    </tbody>
                                                    
                                                    
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="card shadow">
                                <div class="card-body">


                                    <div class="row  ">
                                        <div class="col d-flex justify-content-end">
                                            <p class="mb-0">Total Price</p>
                                        </div>
                                        <div class="col d-flex justify-content-end">
                                            <p class="mb-0">${money_format(cart_total)}</p>
                                        </div>
                                    </div>
                                
                                    <div class="row  ">
                                        <div class="col d-flex justify-content-end">
                                            <p class="mb-0">Total Net weight</p>
                                        </div>
                                        <div class="col d-flex justify-content-end">
                                            <p class="mb-0">${number_format(total_net_weight)} kg</p>
                                        </div>
                                    </div>

                                    <div class="row  ">
                                        <div class="col d-flex justify-content-end">
                                            <p class="mb-0">Average Amount</p>
                                        </div>
                                        <div class="col d-flex justify-content-end">
                                            <p class="mb-0">${ money_format(cart_total/total_net_weight) }</p>
                                        </div>
                                    </div>

                                    <div class="row  ">
                                        <div class="col d-flex justify-content-end">
                                            <p class="mb-0">Total Expenses</p>
                                        </div>
                                        <div class="col d-flex justify-content-end">
                                            <p class="mb-0">${ money_format(total_expenses) }</p>
                                        </div>
                                    </div>
                                
                                
                                    <div class="row  ">
                                        <div class="col d-flex justify-content-end">
                                            <p class="mb-0">Average Cost Price</p>
                                        </div>
                                        <div class="col d-flex justify-content-end">
                                            <p class="mb-0"> ${ money_format( (cart_total + total_expenses)  / total_net_weight)   } </p>
                                        </div>
                                    </div>
                                
                                


                                    <div class="row" >
                                        <div class="col-md-12" >
                                            <h2 class="fw-bold mt-0 text-danger d-flex justify-content-end" style="font-size: 25px">
                                                Amount Due:
                                                <span class="cart_total ml-4" data-cart-total='${cart_total}' >${money_format(cart_total)}</span>
                                            </h2>
                                        </div>

                                        <div class="col-md-12" >
                                                <div class="card mb-0 shadow" >

                                                    <div class="card-body">
                                                    <div class="row">

                                                    <div class="col-md-6" >
                                                        <label>Amount Paid </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">#</span>
                                                            </div>
                                                            <input type="number" class="form-control ammount_paid" id="advance" data-total=${cart_total}  placeholder="Amount">
                                                        </div>    
                                                    </div>


                                                    <div class="col-md-6" >
                                                        <label>Balance </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">#</span>
                                                            </div>
                                                            <input type="text" class="form-control balance " readonly value="${number_format(cart_total)}">
                                                        </div>    
                                                    </div>


                                                    ${lorry}


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                `)

            }


            displayCart();

            $('body').on('click', '.remove_item', function() {
                uuid = $(this).data('uuid');
                items = getItems();
                const index = items.findIndex(object => {
                    return object.uuid == uuid;
                });
                items.splice(index, 1);
                setItem(trno, items);
                displayCart()
            })



            $('body').on('click', '.remove_expense', function() {
                uuid = $(this).data('uuid');
                expenses = (localStorage.getItem('expenses') == null) ? [] : JSON.parse(localStorage
                    .getItem(
                        'expenses'));
                const index = expenses.findIndex(object => {
                    return object.uuid == uuid;
                });
                expenses.splice(index, 1);
                setItem('expenses', expenses);
                displayCart()
            })




            // $('body').on('click', '.ammount_paid', function() {
            //     uuid = $(this).data('uuid');
            //     items = getItems();
            //     const index = items.findIndex(object => {
            //         return object.uuid == uuid;
            //     });
            //     items.splice(index, 1);
            //     setItem(trno, items);
            // })




            var timeout = null;

            $('body').on('change', '.bags', function() {
                clearTimeout(timeout);
                val = $(this).val();
                if (val == "" || isNaN(val)) {
                    console.log('In valid number');
                    return;
                }


                console.log(val);
                uuid = $(this).data('index')
                items = getItems();
                const index = items.findIndex(object => {
                    return object.uuid == uuid;
                });
                items[index].bags = val
                console.log(uuid, index);
                setItem(trno, items);
                displayCart()
            })


            $('body').on('change', '.gross_weight', function() {
                val = parseInt($(this).val());
                if (val == "" || isNaN(val)) {
                    console.log('In valid number');
                    return;
                }
                uuid = $(this).data('index')
                items = getItems();
                const index = items.findIndex(object => {
                    return object.uuid == uuid;
                });
                items[index].gross_weight = val
                console.log(uuid, index);
                setItem(trno, items);
                displayCart()
            })

            $('body').on('change', '.net_weight', function() {
                val = parseInt($(this).val());
                if (val == "" || isNaN(val)) {
                    console.log('In valid number');
                    return;
                }
                uuid = $(this).data('index')
                items = getItems();
                const index = items.findIndex(object => {
                    return object.uuid == uuid;
                });
                items[index].net_weight = val
                console.log(uuid, index);
                setItem(trno, items);
                displayCart()
            })

            $('body').on('change', '.moisture_discount', function() {
                val = parseInt($(this).val());
                if (val == "" || isNaN(val)) {
                    val = 0;
                }
                uuid = $(this).data('index')
                items = getItems();
                const index = items.findIndex(object => {
                    return object.uuid == uuid;
                });
                items[index].moisture_discount = val
                console.log(uuid, index);
                setItem(trno, items);
                displayCart()
            })

            $('body').on('change', '.cart_price', function() {
                val = $(this).val();
                uuid = $(this).data('index')
                items = getItems();
                const index = items.findIndex(object => {
                    return object.uuid == uuid;
                });
                items[index].price = val
                console.log(uuid, index);
                setItem(trno, items);
                displayCart()
            })

            $('body').on('keyup', '#advance', function() {
                total = $(this).data('total');
                adv = $(this).val()
                console.log(total);
                balance = (total - parseInt(adv));
                balance = isNaN(balance) ? total : balance;
                $('.balance').val(money_format(balance))
            })





            function checMeJusOut(btn, print) {
                action = $('#action').val();
                advance = $('#advance').val();
                lorry_number = $('#lorry_number').val() ?? '';

                if (action == 'import') {
                    user = $('#supplier').val();
                } else {
                    user = $('#customer').val();

                    if (lorry_number == '' || !lorry_number) {
                        alert('Lorry number is required whan exporting goods');
                        return;
                    }
                }



                if (!user) {
                    if (action == 'import') {
                        alert('Please select the supplier who is importing the products ');
                    } else {
                        alert('Please select the customer you are exporting to');
                    }
                    return;
                }


                all_items = getItems();

                console.log();

                if (all_items.length <= 0) {
                    alert('You have not added any product');
                    displayCart();
                    return;
                }

                end_point = ''

                if (action == 'export') {
                    end_point = '/control/make_export'
                } else {
                    end_point = '/control/import_stock'
                }


                btn_html = btn.html();

                summary_id = `0`;
                console.log(summary_id);

                $.ajax({
                    method: 'post',
                    url: end_point,
                    data: {
                        '_token': `{{ csrf_token() }}`,
                        items: all_items,
                        expenses: (localStorage.getItem('expenses') == null) ? [] : JSON.parse(localStorage
                            .getItem('expenses')),
                        customer_id: user,
                        sales_id: trno,
                        advance: advance,
                        action: action,
                        lorry_number: lorry_number,
                    },
                    beforeSend: () => {
                        btn.html(`
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Checking Out...  
                    `)
                    }
                }).done(function(res) {



                    localStorage.removeItem(trno)
                    localStorage.removeItem('expenses')


                    console.log(res);

                    Toastify({
                        text: `${res.message}`,
                        className: "info",
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        }
                    }).showToast();

                    btn.html(`${btn_html}`);
                    $('.all_content').hide();

                    window.location.href = `/control/pos?trno=${trno}`


                }).fail(function(res) {
                    console.log(res);
                    btn.html(`${btn_html}`)

                })
            }

            $('.checkout').on('click', function(e) {
                e.preventDefault();
                console.log(trno);
                btn = $(this)
                checMeJusOut(btn, 'print');
            })

            $('.checkout-only').on('click', function(e) {
                e.preventDefault();
                btn = $(this)
                checMeJusOut(btn, 'no-print');
            })


            $('.clear_cart').on('click', function() {
                trno = $(this).data('trno');
                localStorage.removeItem(trno);
                localStorage.removeItem('expenses');
                displayCart()
            })


            $(document).on('click', '.search_item', function() {
                console.log(this);
                item = $(this).data('data');
                cart = (localStorage.getItem(trno) == null) ? [] : JSON.parse(localStorage.getItem(
                    trno));
                arr = {
                    uuid: Math.floor(Math.random() * 1000),
                    id: item.id,
                    bags: 1,
                    name: `${item.name}`,
                    price: item.price,
                    gross_weight: 10,
                    net_weight: 1,
                    moisture_discount: 0,
                    final_weight: 0,
                    quantity: item.quantity,
                    type: item.type
                }
                cart.push(arr);
                $('.sbox').hide();
                $('#search').val(``);
                $('#search').removeAttr('autofocus');
                $('#search').attr('autofocus', 'autofocus');
                localStorage.setItem(trno, JSON.stringify(cart));
                displayCart();
                // location.reload();
            });


            $('body').on('click', '.add_expense', function(e) {

                e.preventDefault();

                expense_title = $('.expense_title');
                expense_amount = $('.expense_amount');
                if (!expense_title.val() || !expense_amount.val()) {
                    alert('All expense field are required');
                    return
                }
                expenses = (localStorage.getItem('expenses') == null) ? [] : JSON.parse(localStorage
                    .getItem('expenses'));
                arr = {
                    uuid: Math.floor(Math.random() * 1000),
                    title: expense_title.val(),
                    amount: expense_amount.val(),
                }
                expenses.push(arr);
                $('.expense_title').val(``);
                $('.expense_amount').val(``);
                localStorage.setItem('expenses', JSON.stringify(expenses));
                displayCart();
            })



            function checkAction() {
                action = $('#action').val()
                console.log(action);

                action_alert = $('.action_alert');

                if (action == 'export') {
                    action_alert.html(`
                    <h5 class="text-whi mt-0" >Export Products</h5>
                            Please always confirm you action and select the name of Customer you want export to 
                    `)

                    action_alert.addClass('alert-warning')
                    action_alert.removeClass('alert-info')

                    $('.supplier').css('display', 'none')
                    $('.customer').css('display', 'block')
                } else {
                    action_alert.addClass('alert-info')
                    action_alert.removeClass('alert-warning')
                    action_alert.html(
                        `
                    <h5 class="text-whi mt-0" >Import Products</h5>
                            Please always confirm you action and select the correct name of suppler                     `
                    )

                    $('.customer    ').css('display', 'none')
                    $('.supplier').css('display', 'block')
                }


            }


            $('#action').on('change', function() {
                checkAction()

                displayCart();
            })

            checkAction();



        })
    </script>
@endpush
