<?php

use App\Models\Capital;
use App\Models\Export;
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
    $total_received = Export::where(['customer_id' => $user_id])->sum('total');
    $total_capital = Stock::where(['customer_id' => $user_id, 'action' => 'capital'])->sum('total');
    $adjustment = Stock::where([ 'customer_id' => $user_id, ['action',  'like', "%adjustment%"]])->sum('total');
    return ($total_capital ) - $total_received - $adjustment;
}



function supplierCredit($supplier_id)
{
    $total_received = Stock::where(['supplier_id' => $supplier_id, 'action' => 'import'])->sum('total');
    $adjustment_1 = Stock::where([ 'supplier_id' => $supplier_id, ['action',  'like', "%adjustment%"]])->sum('total');
    $adjustment = $adjustment_1;
    $total_capital = Stock::where(['supplier_id' => $supplier_id, 'action' => 'capital'])->sum('total');

    return ($total_capital - $total_received) - $adjustment;
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



function forceLedger($transaction)
{
}



function touchBalance($stock_id, $client_id , $action="supplier")
{
    if($action == 'supplier') {
        $total_received = Stock::where([['id', '<=', $stock_id], 'supplier_id' => $client_id, 'action' => 'import'])->sum('total');
        $adjustment_1 = Stock::where([['id', '<=', $stock_id], 'supplier_id' => $client_id, ['action',  'like', "%adjustment%"]])->sum('total');
        $adjustment = $adjustment_1;
        $total_capital = Stock::where([['id', '<=', $stock_id], 'supplier_id' => $client_id, 'action' => 'capital'])->sum('total');
    
        return ($total_capital - $total_received) - $adjustment;
    }else {
        $total_received = Stock::where([['id', '<=', $stock_id], 'customer_id' => $client_id, 'action' => 'client_export' , ])->sum('total');
    
        $total_capital = Stock::where([['id', '<=', $stock_id], 'customer_id' => $client_id, 'action' => 'capital'])->sum('total');
        $adjustment = Stock::where([['id', '<=', $stock_id], 'customer_id' => $client_id, ['action',  'like', "%adjustment%"]])->sum('total');

        // $adjustment = Stock::where([ 'customer_id' => $client_id, ['action',  'like', "%adjustment%"]])->sum('total');
    
        return ($total_capital ) - $total_received - $adjustment;
    }

}
