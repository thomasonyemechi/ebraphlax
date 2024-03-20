<?php

namespace App\Http\Controllers;

use App\Models\Capital;
use App\Models\Customer;
use App\Models\Sales;
use App\Models\SalesSummary;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    function addCustomer(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'string|required',
            'company_name' => 'string', 
            'nick_name' => 'string|required', 
            'email' => 'email|required', 
            'phone' => 'required|unique:customers,phone', 
            'address' => 'string'
        ])->validate();


        Customer::create([
            'name' => $request->name,
            'company_name' => $request->company_name,
            'nick_name' => $request->nick_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        return back()->with('success', 'Customer profile has been created');
    }


    function addCustomerIndex()
    {
        
        return view('control.add_customer');
    }


    function customerListIndex(Request $request)
    {
        if ($request->customer) {
            $customers = Customer::where('name', 'like', "%$request->customer%")->orwhere('nick_name', 'like', "%$request->customer%")
                ->orwhere('company_name', 'like', "%$request->customer%")->orwhere('phone', 'like', "%$request->customer%")->orwhere('address', 'like', "%$request->customer%")->orderby('name', 'asc')->paginate(21);
        } else {
            $customers = Customer::orderby('id', 'desc')->paginate(27);
        }

        return view('control.customers', compact(['customers']));
    }


    function customerIndex($customer_id)
    {
        $customer = Customer::findorfail($customer_id);


        $customer = Customer::findorfail($customer_id);

        $stocks = Stock::where(['customer_id' => $customer->id, 'action' => 'export'])->orderby('id', 'desc')->paginate(50);

        $total_capital = Capital::where(['user_id' => $customer->id, 'type' => 'export'])->sum('amount');
        $capitals = Capital::where(['user_id' => $customer->id, 'type' => 'export'])->orderby('id', 'desc')->limit(5)->get();
        $total_supplied = Stock::where(['customer_id' => $customer->id, 'action' => 'export'])->sum('total');
        
        ;
        return view('control.customer', compact(['customer', 'capitals', 'total_capital', 'total_supplied', 'stocks']));
    }



    function customerBalanceIndex()
    {
        $customers = Customer::orderby('name', 'asc')->paginate(100);
        foreach($customers as $cus) {
            $cus->account_summary = $this->calculatePurchases($cus->id);
        }
        return view('control.customer_balance', compact(['customers']));
    }


    function calculatePurchases($customer_id)
    {
        $total_purchased = SalesSummary::where(['customer_id' => $customer_id])->sum('total');
        $total_paid = SalesSummary::where(['customer_id' => $customer_id])->sum('amount_paid');
        $stocks = SalesSummary::with(['sales'])->where(['customer_id' => $customer_id])->get(['id']);
        $total_capital = Capital::where(['user_id' => $customer_id, 'type' => 'export'])->sum('amount');
        $total_net_weight = 0;
        foreach($stocks as $stocks) {
            $total_net_weight += $stocks->sales->sum('net_weight');
        }
        return [
            'capital_balance' => customerCredit($customer_id), 
            'total_purcahsed' => $total_purchased, 
            'total_paid' => $total_paid, 
            'total_net_weight' => $total_net_weight,
            'total_capital' => $total_capital
        ];
    }
}
