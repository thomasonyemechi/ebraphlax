<?php

namespace App\Http\Controllers;

use App\Models\Capital;
use App\Models\RestockSummary;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{

    function allSupplierIndex()
    {
        return view('control.suppliers');
    }


    function supplierListIndex(Request $request)
    {
        if ($request->supplier) {
            $suppliers = Supplier::where('name', 'like', "%$request->supplier%")->orwhere('nick_name', 'like', "%$request->supplier%")
                ->orwhere('company_name', 'like', "%$request->supplier%")->orwhere('phone', 'like', "%$request->supplier%")->orwhere('address', 'like', "%$request->supplier%")->orderby('name', 'asc')->paginate(21);
        } else {
            $suppliers = Supplier::orderby('id', 'desc')->paginate(21);
        }


        return view('control.suppliers_list', compact(['suppliers']));
    }


    function supplierIndex($supplier_id)
    {
        $supplier = Supplier::findorfail($supplier_id);

        $stocks = Stock::where(['supplier_id' => $supplier->id])->orderby('id', 'desc')->limit(50)->get();

        $total_capital = Stock::where(['supplier_id' => $supplier->id, 'action' => 'capital'])->sum('total');
        $capitals = Stock::where(['supplier_id' => $supplier->id, 'action' => 'capital'])->orderby('id', 'desc')->limit(5)->get();
        $total_supplied = Stock::where(['supplier_id' => $supplier->id, 'action' => 'import'])->sum('total');

        $total_paid =  Stock::where(['supplier_id' => $supplier->id, 'action' => 'import'])->sum('amount_paid');


        $balance = $total_capital - $total_supplied + $total_paid;
        return view('control.supplier', compact(['supplier', 'capitals', 'total_capital', 'total_supplied', 'stocks', 'balance']));
    }


    function addSupplier(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'string|required',
            'company_name' => 'string',
            'nick_name' => 'string|required',
            'phone' => 'required|unique:suppliers,phone',
            'address' => 'string'
        ])->validate();


        Supplier::create([
            'name' => $request->name,
            'company_name' => $request->company_name,
            'nick_name' => $request->nick_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        return back()->with('success', 'Importer profile has been created');
    }


    function supplierBalanceIndex()
    {
        $suppliers = Supplier::orderby('name', 'asc')->paginate(1500);

        $total_credit = $total_debit = 0;

        foreach($suppliers as $cus) {
            $sup_bal = supplierCredit($cus->id);

            if($sup_bal > 0) {
                $total_debit += $sup_bal;
            }else {
                $total_credit +=  $sup_bal;
            }

            $cus->account_summary = $this->calculateSupply($cus->id);
        }

        
        return view('control.supplier_balance', compact(['suppliers', 'total_debit', 'total_credit']));
    }


    function calculateSupply($customer_id)
    {
        $total_purchased = Stock::where(['supplier_id' => $customer_id, 'action' => 'import'])->sum('total');
        $total_paid = Stock::where(['supplier_id' => $customer_id,  'action' => 'import'])->sum('amount_paid');
        $stocks = Stock::where(['supplier_id' => $customer_id])->get();

        $total_capital = Stock::where(['supplier_id' => $customer_id, 'action' => 'capital'])->sum('total');
        $total_net_weight = 0;
        foreach($stocks as $stocks) {
            $total_net_weight += $stocks->sum('net_weight');
        }
        return [
            'capital_balance' => supplierCredit($customer_id), 
            'total_purcahsed' => $total_purchased, 
            'total_paid' => $total_paid, 
            'total_net_weight' => $total_net_weight,
            'total_capital' => $total_capital
        ];
    }
}
