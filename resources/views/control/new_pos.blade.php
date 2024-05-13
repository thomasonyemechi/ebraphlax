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
                        <div class="col-md-4">
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

                        <div class="col-md-8">
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
                        <h5 class="text-whi mt-0">Export Products</h5>
                        Please always confirm you action and select the name of Customer you want export to
                    </div>


                    <div class="d-flex mb-3  justify-content-start">
                        @foreach (\App\Models\Products::get() as $pro)
                            <a href="/control/pos?trno={{ $_GET['trno'] }}&product={{ $pro->id }}"
                                class="btn shadow {{ $_GET['product'] == $pro->id ? 'btn-info' : ' btn-secondary' }} mr-2">{{ $pro->name }}
                            </a>
                        @endforeach
                    </div>

                    <div class="card mt-z  all_content " style="display: none">
                        <div class="card-body p-3 ">

                            <div class="table-responsive">
                                <table class="table table-sm " style="border: 0 !important">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Client</th>
                                            <th class="text-start" colspan="2">Product</th>
                                            <th class="text-start">Bags</th>

                                            <th>Gros/wt (kg)</th>
                                            <th>Moisture/dis</th>
                                            <th>Tares</th>
                                            <th>Net/wt (kg)</th>

                                            <th>Price (₦)</th>
                                            <th>Ext Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="cart_list">

                                        @if (count($available_stock) == 0)
                                            <tr>
                                                <td colspan="12">
                                                    <div class="alert alert-warning mt-2 mb-2">
                                                        The is no product in stock
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif

                                        @foreach ($available_stock as $stock)
                                            <tr class="row_{{ $stock->id }}">
                                                <td>
                                                    <div class="icheck-primary ">
                                                        <input type="checkbox" class="open_boot"
                                                            name="stock_{{ $stock->id }}"
                                                            data-index="{{ $stock->id }}">
                                                        <label for="stock_{{ $stock->id }}"></label>
                                                        <input type="hidden" name="product_{{ $stock->id }}"
                                                            value="{{ json_encode($stock->product) }}">
                                                    </div>
                                                </td>
                                                <td><span class="fw-bold ">{{ $stock->client->name }}</span></td>
                                                <td colspan="2"><span
                                                        class="fw-bold ">{{ $stock->product->name }}</span>
                                                </td>
                                                <td><input type="number" class="bags form-control px-2 me-2 py-0 p-0"
                                                        min="1" max="{{ $stock->bags - $stock->bags_out }}"
                                                        step="any" name="bags_{{ $stock->id }}"
                                                        value="{{ $stock->bags - $stock->bags_out }}"
                                                        data-index="{{ $stock->id }}" style="width:60px"></td>
                                                <td><input type="number"
                                                        class="gross_weight form-control px-2 me-2 py-0 p-0" min="1"
                                                        max="{{ $stock->gross_weight }}"
                                                        value="{{ $stock->gross_weight }}"
                                                        data-index="{{ $stock->id }}"
                                                        name="gross_weight_{{ $stock->id }}" readonly
                                                        style="width:100px"></td>
                                                <td><input type="number"
                                                        class="moisture_discount form-control px-2 me-2 py-0 p-0"
                                                        min="0" max="{{ $stock->moisture_discount }}" step="any"
                                                        name="moisture_discount_{{ $stock->id }}"
                                                        value="{{ $stock->moisture_discount }}"
                                                        data-index="{{ $stock->id }}" style="width:60px"></td>
                                                <td>
                                                    <input type="number" class="tares form-control px-2 me-2 py-0 p-0"
                                                        min="1" max="{{ $stock->tares }}" step="any"
                                                        value="{{ $stock->tares }}" data-index="{{ $stock->index }}"
                                                        name="tares_{{ $stock->id }}" data-index="{{ $stock->id }}"
                                                        style="width:100px">
                                                </td>
                                                <td><input type="number" class="net_weight form-control px-2 me-2 py-0 p-0"
                                                        min="1" max="{{ $stock->net_weight - $stock->weight_out }}"
                                                        step="any"
                                                        value="{{ $stock->net_weight - $stock->weight_out }}"
                                                        data-index="{{ $stock->id }}"
                                                        name="net_weight_{{ $stock->id }}" style="width:100px"></td>
                                                <td><input type="number" class="cart_price form-control px-2 me-2 py-0 p-0"
                                                        name="price_{{ $stock->id }}" min="1" readonly
                                                        value="{{ $stock->price }}" data-index="{{ $stock->id }}"
                                                        style="width:80px">
                                                </td>
                                                <td>
                                                    <span class="item_total_{{ $stock->id }}">
                                                        {{ money($stock->total) }} </span>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                            <div class="total_area">
                                <div class="row sales_sum mt-2 px-2 py-3 ">
                                    <div class="col-md-6">
                                        <div class="card shadow" style="height : 350px; overflow-y: scroll">
                                            <div class="card-body">
                                                <big class="mb-2">Add expenses incured</big>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <input type="text" class="form-control expense_title"
                                                            placeholder="Expenses">
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="number" class="form-control expense_amount"
                                                            placeholder="Amount">
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
                                                                        <th class="text-start">Title</th>
                                                                        <th>Amount</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody id="expense_body">




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
                                                    <div class="col d-flex total_price justify-content-end">
                                                        <p class="mb-0">0.00</p>
                                                    </div>
                                                </div>

                                                <div class="row  ">
                                                    <div class="col d-flex justify-content-end">
                                                        <p class="mb-0">Total Net weight</p>
                                                    </div>
                                                    <div class="col d-flex justify-content-end">
                                                        <p class="mb-0 total_net_weight">0.00 kg</p>
                                                    </div>
                                                </div>

                                                <div class="row  ">
                                                    <div class="col d-flex justify-content-end">
                                                        <p class="mb-0">Average Amount</p>
                                                    </div>
                                                    <div class="col d-flex justify-content-end">
                                                        <p class="mb-0 average_amount">₦ 0</p>
                                                    </div>
                                                </div>

                                                <div class="row  ">
                                                    <div class="col d-flex justify-content-end">
                                                        <p class="mb-0">Total Expenses</p>
                                                    </div>
                                                    <div class="col d-flex justify-content-end">
                                                        <p class="mb-0 total_expense">₦ 0.00</p>
                                                    </div>
                                                </div>


                                                <div class="row  ">
                                                    <div class="col d-flex justify-content-end">
                                                        <p class="mb-0">Average Cost Price</p>
                                                    </div>
                                                    <div class="col d-flex justify-content-end">
                                                        <p class="mb-0 average_cost_price"> ₦ 0.00 </p>
                                                    </div>
                                                </div>




                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h2 class="fw-bold mt-0 text-danger d-flex justify-content-end"
                                                            style="font-size: 25px">
                                                            Amount Due:
                                                            <span class="cart_total ml-4" data-cart-total="8075">₦
                                                                0.00</span>
                                                        </h2>
                                                        <hr>

                                                        <div class="row">
                                                            <div class="col-md-5 mb-3">
                                                                <label for="">Enter Sales Price</label>
                                                                <input type="number"
                                                                    class="sales_price form-control px-2 me-2 py-0 p-0"
                                                                    step="any" name="sales_price" style="width:100%">
                                                            </div>
                                                            <div class="col-md-7">
                                                                <h2 class="fw-bold mt-2 d-flex justify-content-end"
                                                                    style="font-size: 17px">
                                                                    Total Sales Price:
                                                                    <span class=" ml-4 total_sales_price">₦ 0.00</span>
                                                                </h2>

                                                                <h2 class="fw-bold mt-0 d-flex justify-content-end"
                                                                    style="font-size: 23px">
                                                                    Total Gain/Loss:
                                                                    <span class=" ml-4 total_gain">₦ 0.00</span>
                                                                </h2>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="row">

                                                            <div class="col-md-6">
                                                                <label>Amount Paid </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">#</span>
                                                                    </div>
                                                                    <input type="number"
                                                                        class="form-control ammount_paid" id="advance"
                                                                        data-total="8075" placeholder="Amount">
                                                                </div>
                                                            </div>


                                                            <div class="col-md-6">
                                                                <label>Balance </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">#</span>
                                                                    </div>
                                                                    <input type="text" class="form-control balance "
                                                                        readonly="" value="">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 mt-3">
                                                                <div class="form-group">
                                                                    <label>Lorry Number</label>
                                                                    <input type="text"
                                                                        class="form-control lorry_number"
                                                                        id="lorry_number" placeholder="Lorry Number">
                                                                </div>
                                                            </div>



                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
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


            </div>

        </div>
    </div>
@endsection



@push('scripts')
    <script>
        $(document).ready(function() {

            $('.all_content').show()

            $(function() {

                function calculateNetWeight(gross_weight, discount, rate, tares, type = 1) {

                    if (type == 2) {
                        net_weight = (gross_weight / rate) * 1000;
                        console.log(net_weight);
                        return net_weight;
                    } else {
                        console.log('fucker');
                        console.log(gross_weight, tares);
                        return (gross_weight - discount) - tares
                    }
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
                    items = (localStorage.getItem(trno) == null) ? [] : JSON.parse(localStorage.getItem(
                        trno));
                    return items;
                }

                function setItem(trno, items) {
                    localStorage.setItem(trno, JSON.stringify(items));
                }


                // function calculateGain()
                // {

                // }






                function dototals() {

                    inputs = $('.open_boot')

                    total_net_weight = total_price = 0

                    cart = [];

                    inputs.map(input => {
                        input = inputs[input]
                        if (input.checked) {


                            indexx = $(input).data('index');

                            row = $(`.row_${indexx}`)

                            net_weight = parseInt(row.find(`input[name="net_weight_${indexx}"]`)
                                .val())

                            total_net_weight += net_weight;
                            total_price += parseInt(row.find(`input[name="price_${indexx}"]`)
                                    .val()) *
                                net_weight

                            arr = {
                                stock_id: indexx,
                                bags: parseInt(row.find(`input[name="bags_${indexx}"]`).val()),
                                tares: parseInt(row.find(`input[name="tares_${indexx}"]`)
                                .val()),
                                moisture_discount: parseInt(row.find(
                                    `input[name="moisture_discount_${indexx}"]`).val()),
                                price: parseInt(row.find(`input[name="price_${indexx}"]`)
                                    .val()),
                                net_weight: parseInt(row.find(
                                    `input[name="net_weight_${indexx}"]`).val()),
                            }
                            cart.push(arr);
                        }
                    });

                    localStorage.setItem(trno, JSON.stringify(cart));

                    $('.total_price').html(money_format(total_price))
                    $('.cart_total').html(money_format(total_price))
                    $('.total_net_weight').html(`${number_format(total_net_weight)} kg`)
                    $('.average_amount').html(money_format(total_price / total_net_weight))
                    $('#advance').attr('data-total', total_price)



                    expenses = (localStorage.getItem(`expenses_${trno}`) == null) ? [] : JSON.parse(
                        localStorage
                        .getItem(`expenses_${trno}`));
                    console.log(expenses);
                    total_expenses = 0;
                    expense_body = $('#expense_body')
                    expense_body.html(``);
                    expenses.map((expense, index) => {
                        total_expenses += parseInt(expense.amount);
                        expense_body.append(`
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
                    
                    `)
                    })

                    $('.total_expense').html(money_format(total_expenses))

                    $('.total_net_weight').attr('data-net_weight', total_net_weight)
                    $('.total_net_weight').attr('data-expenses', total_expenses)


                    average_cost_price = (total_price + total_expenses) / total_net_weight




                    $('.average_cost_price').html(money_format(average_cost_price.toFixed(2)));



                    return;
                }


                function makeDisplay(index) {



                    product = $(`input[name="product_${index}"]`).val()
                    product = JSON.parse(product)
                    console.log(product);


                    bags = $(`input[name="bags_${index}"]`).val();
                    gross_weight = $(`input[name="gross_weight_${index}"]`).val();
                    rate = $(`input[name="rate_${index}"]`).val();
                    discount = $(`input[name="moisture_discount_${index}"]`).val()

                    // net_weight = $('input[name="net_weight"]');

                    tares = $(`input[name="tares_${index}"]`);
                    tares_kg = tares.val();

                    price = $(`input[name="price_${index}"]`).val();

                    net_kg = calculateNetWeight(gross_weight, parseInt(discount), rate, tares_kg, product
                        .type)
                    console.log(net_kg, 'net_kg');
                    $(`input[name="net_weight_${index}"]`).val(net_kg.toFixed(1));

                    defd = $(`span[class="item_total_${index}"]`);

                    total = (net_kg * price)
                    defd.html(money_format(total))

                    dototals();
                }


                function changeNetWeight(index) {

                    price = $(`input[name="price_${index}"]`).val();
                    net_kg = $(`input[name="net_weight_${index}"]`).val();
                    defd = $(`span[class="item_total_${index}"]`);
                    total = (net_kg * price)
                    defd.html(money_format(total))

                    dototals()
                }


                $('body').on('keyup', '#advance', function() {
                    total = $(this).data('total');
                    adv = $(this).val()
                    console.log(total);
                    balance = (total - parseInt(adv));
                    balance = isNaN(balance) ? total : balance;
                    $('.balance').val(money_format(balance))
                })


                $('body').on('keyup', '.sales_price', function() {
                    sales_perkg = parseInt($(this).val());
                    cost_price = $('#advance').data('total');
                    net_weight = $('.total_net_weight').data('net_weight')
                    expenses = $('.total_net_weight').data('expenses')


                    total_sales_price = (net_weight * sales_perkg)

                    $('.total_sales_price').html(`${money_format(total_sales_price ?? 0)}`)

                    total_gain = total_sales_price - cost_price - expenses

                    gain = $('.total_gain');

                    gain.html(`${ money_format(total_gain) }`)

                    if (total_gain > 0) {
                        gain.removeClass('text-danger')
                        gain.addClass('text-success')
                    } else {
                        gain.removeClass('text-success')
                        gain.addClass('text-danger')
                    }


                })




                $('.bags').on('change', function() {
                    index = $(this).data('index');
                    console.log(index);
                    makeDisplay(index);
                })

                $('.net_weight').on('change', function() {
                    index = $(this).data('index');
                    changeNetWeight(index);
                })

                $('.tares').on('change', function() {
                    index = $(this).data('index');
                    makeDisplay(index);
                })

                $('.moisture_discount').on('change', function() {
                    index = $(this).data('index');
                    makeDisplay(index);
                })

                $('.price').on('change', function() {
                    index = $(this).data('index');
                    makeDisplay(index);
                })



                $('input[type="number"]').attr('disabled', 'disabled')
                $('.expense_amount').removeAttr('disabled')
                $('.ammount_paid').removeAttr('disabled')
                $('.sales_price').removeAttr('disabled')

                $('body').on('click', '.open_boot', function() {
                    index = $(this).data('index');
                    console.log(index);
                    single_row = $(`.row_${index}`)

                    check_box = single_row.find(`input[name="stock_${index}"]`);
                    console.log(check_box.val());

                    if (check_box.val() == 'on') {
                        check_box.val('off');
                        single_row.find(`input[type="number"]`).removeAttr('disabled');

                    } else {
                        check_box.val('on');
                        single_row.find(`input[type="number"]`).attr('disabled', 'disabled');
                    }

                    dototals();
                })


                $('body').on('click', '.add_expense', function(e) {
                    e.preventDefault();
                    expense_title = $('.expense_title');
                    expense_amount = $('.expense_amount');
                    if (!expense_title.val() || !expense_amount.val()) {
                        alert('All expense field are required');
                        return
                    }
                    expenses = (localStorage.getItem(`expenses_${trno}`) == null) ? [] : JSON.parse(
                        localStorage
                        .getItem(`expenses_${trno}`));


                    arr = {
                        uuid: Math.floor(Math.random() * 1000),
                        title: expense_title.val(),
                        amount: expense_amount.val(),
                    }
                    expenses.push(arr);
                    $('.expense_title').val(``);
                    $('.expense_amount').val(``);
                    localStorage.setItem(`expenses_${trno}`, JSON.stringify(expenses));

                    dototals();
                })


                $('body').on('click', '.remove_expense', function() {
                    uuid = $(this).data('uuid');
                    expenses = (localStorage.getItem(`expenses_${trno}`) == null) ? [] : JSON.parse(
                        localStorage
                        .getItem(`expenses_${trno}`));
                    const index = expenses.findIndex(object => {
                        return object.uuid == uuid;
                    });
                    expenses.splice(index, 1);
                    setItem(`expenses_${trno}`, expenses);
                    dototals()
                })




                function checMeJusOut(btn, print = "") {
                    action = $('#action').val();
                    advance = $('#advance').val();
                    lorry_number = $('#lorry_number').val() ?? '';

                    user = $('#customer').val();

                    if (lorry_number == '' || !lorry_number) {
                        alert('Lorry number is required whan exporting goods');
                        return;
                    }

                    if (!user) {
                        alert('Please select the customer you are exporting to');
                        return;
                    }


                    all_items = getItems();

                    if (all_items.length <= 0) {
                        alert('You have not added any product');
                        return;
                    }

                    console.log(all_items);

                    end_point = '/control/make_export'
                    btn_html = btn.html();

                    total = $('#advance').data('total');


                    $.ajax({
                        method: 'post',
                        url: end_point,
                        data: {
                            '_token': `{{ csrf_token() }}`,
                            items: all_items,
                            expenses: (localStorage.getItem(`expenses_${trno}`) == null) ? [] : JSON
                                .parse(localStorage
                                    .getItem(`expenses_${trno}`)),
                            customer_id: user,
                            sales_id: trno,
                            advance: advance,
                            action: action,
                            lorry_number: lorry_number,
                            sales_price: $('.sales_price').val(),
                            total
                        },
                        beforeSend: () => {
                            btn.html(`
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saaving this consigment ...  
                    `)
                        }
                    }).done(function(res) {



                        localStorage.removeItem(trno)
                        localStorage.removeItem(`expenses_${trno}`)


                        console.log(res);

                        Toastify({
                            text: `${res.message}`,
                            className: "bg-info",
                            style: {
                                background: "linear-gradient(to right, #00b09b, #96c93d)",
                            }
                        }).showToast();

                        btn.html(`${btn_html}`);
                        // $('.all_content').hide();

                        setTimeout(() => {
                            location.reload();
                        }, 3000);


                    }).fail(function(res) {
                        console.log(res);
                        btn.html(`${btn_html}`)

                    })
                }



                $('.checkout').on('click', function(e) {
                    e.preventDefault();
                    console.log(trno);
                    btn = $(this)
                    checMeJusOut(btn);
                })




                dototals();
            })
        });
    </script>
@endpush
