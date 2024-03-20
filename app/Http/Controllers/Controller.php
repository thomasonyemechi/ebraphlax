<?php

namespace App\Http\Controllers;

use App\Models\Cstock;
use App\Models\Customer;
use App\Models\Expenses;
use App\Models\Products;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function dashboardIndex()
    {
        $total_customer = Customer::count();
        $total_supplier = Supplier::count();
        $total_product = Products::count();
        $total_sales = Stock::where('action', 'export')->count();
        $total_import = Stock::where('action', 'import')->count();
        $sales_amount = Stock::where('action', 'export')->sum('total');
        $total_expenses = Expenses::count();
        $expenses_amount = Expenses::sum('amount');
        $total_stock = Stock::count();
        $invoice_by_you = Stock::where(['user_id' => auth()->user()->id])->count();
        $sales_by_you = Stock::where(['user_id' => auth()->user()->id, 'action' => 'export'])->sum('total');
        return view('control.index', compact([
            'total_customer', 'total_supplier', 'total_product', 'total_sales', 'sales_amount', 'total_expenses', 'expenses_amount', 'total_stock'
            ,'invoice_by_you', 'sales_by_you', 'total_import'
        ]));
    }



    
    function productBags($product_id)
    {
        $total_bags = Stock::where(['product_id' => $product_id])->sum('bags');
        return $total_bags;
    }

    function productWeight($product_id)
    {
        $total_bags = Stock::where(['product_id' => $product_id])->sum('net_weight');
        return $total_bags;
    }


}
