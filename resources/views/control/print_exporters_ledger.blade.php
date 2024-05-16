<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Ledger | {{ $customer->name }} </title>
    <link href="{{ asset('assets/css/bootstrap.min.css ') }}" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="m-0 p-0">
        <div class="text-center">
            <h1 style="font-size: 50px !important">{{ strtoupper('ebraphlak ').ucfirst('Nigeria Limited') }}</h1>
            <i style="font-size: 17px" class="fw-bold"> Motto: God with us </i>
            <h3>No 63/65, sabo college road, ondo</h3>
            <h4>ebraphlak@yahoo.com</h4>
            <div class="badge badge-success pt-0 " style="font-size: 30px">
                Customer Ledger
            </div>

            <p class="mb-0">Customer address: {{ $customer->address }}</p>
            
        </div>



<div class="row" >

    <div class="col-md-4 m-0 mt-2">
        <div class="card m-0 mb-3">
            <div class="card-body m-0 p-2">
                <h5 class=" fw-bold mb-0 " style="font-size: 30px;"> {{ $customer->name }} ({{ $customer->phone }})
                </h5>
      
            </div>
        </div>
    </div>

    <div class="col-md-4 m-0 mt-2">
        <div class="card m-0">
            <div class="card-body m-0 p-2">
                <div class="d-flex justify-content-between py-2">
                    <span>Total Supplied</span>
                    <span class="text-">
                        {{ money($total_supplied) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 m-0 mt-2">
        <div class="card m-0">
            <div class="card-body m-0 p-2">
                <div class="d-flex justify-content-between py-2">
                    <span>Balance</span>
               ]
                    <span class="{{ $balance > 0 ? 'text-success' : 'text-danger' }} ">
                        {{ $balance > 0 ? 'To Supply' : 'owing' }}

                        ({{ money($balance) }})
                    </span>
                </div>
          
            </div>
        </div>
    </div>

</div>
    </div>
    @include('control.ledger')
</body>




</html>
