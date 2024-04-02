<?php

use App\Models\Capital;
use App\Models\RestockSummary;
use App\Models\Sales;
use App\Models\SalesSummary;
use App\Models\Stock;

function def()
{
    return true;
}


function money($money)
{
    return '₦ ' . number_format($money);
}

function itemQty($id)
{
    return Stock::where(['product_id' => $id])->sum('net_weight');
}


function customerCredit($user_id)
{
    $first_capital = Stock::where(['customer_id' => $user_id, 'action' => 'capital'])->first();

    if(!$first_capital){
        return 0;
    }

    // return $first_capital;
    // get total capital used from first datte of first capital assigned
    $total_received = Stock::where(['customer_id' => $user_id, 'action' => 'export' , ])->sum('total');
    $amount_paid = Stock::where(['customer_id' => $user_id, 'action' => 'export' , ])->sum('amount_paid');

    $total_capital = Stock::where(['customer_id' => $user_id, 'action' => 'capital'])->sum('total');

    return ($total_capital + $amount_paid) - $total_received;
    
}



function supplierCredit($supplier_id)
{
    $first_capital = Stock::where(['supplier_id' => $supplier_id, 'action' => 'capital'])->first();

    if(!$first_capital){
        return 0;
    }

    // return $first_capital;
    // get total capital used from first datte of first capital assigned
    $total_received = Stock::where(['supplier_id' => $supplier_id, 'action' => 'import'])->sum('total');

    $amount_paid = Stock::where(['supplier_id' => $supplier_id, 'action' => 'import'])->sum('amount_paid');

    $total_capital = Stock::where(['supplier_id' => $supplier_id, 'action' => 'capital'])->sum('total');

    return ($total_capital + $amount_paid) - $total_received;
}


function getAmmountPaid($sales_id)
{
    $sales = Sales::where(['id' => $sales_id])->first(['id', 'summary_id']);

    if(!$sales) {
        return 0;
    }
    $sales_sumary = SalesSummary::where(['id' => $sales->summary_id])->first(['amount_paid']);
    if(!$sales_sumary){
        return 0;
    }

    return $sales_sumary->amount_paid;
}