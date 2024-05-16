<?php

namespace App\Http\Controllers;

use App\Models\Capital;
use App\Models\Customer;
use App\Models\Sales;
use App\Models\SalesSummary;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{

    function editCustomer(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'string|required',
            'company_name' => 'string', 
            'nick_name' => 'string|required', 
        ])->validate();


        Customer::where('id', $request->customer_id)->update([
            'name' => $request->name,
            'company_name' => $request->company_name,
            'nick_name' => $request->nick_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        return back()->with('success', 'Customer profile was sucessfully updated');
    }


    function addCustomer(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'string|required',
            'company_name' => 'string', 
            'nick_name' => 'string|required', 
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
            $customers = Customer::where('id', 'like', "%$request->customer%")->orwhere('name', 'like', "%$request->customer%")->orwhere('nick_name', 'like', "%$request->customer%")
                ->orwhere('company_name', 'like', "%$request->customer%")->orwhere('phone', 'like', "%$request->customer%")->orwhere('address', 'like', "%$request->customer%")->orderby('id', 'asc')->paginate(21);
        } else {
            $customers = Customer::orderby('id', 'desc')->paginate(27);
        }

        return view('control.customers', compact(['customers']));
    }


    function customerIndex($customer_id)
    {
        $customer = Customer::findorfail($customer_id);

        $stocks = Stock::where(['customer_id' => $customer->id])->orderby('id', 'desc')->paginate(50);

        // $stocks->groupBy('summary_id');

        $total_capital = Stock::where(['customer_id' => $customer->id, 'action' => 'capital'])->sum('total');
        $capitals = Stock::where(['customer_id' => $customer->id, 'action' => 'capital'])->orderby('id', 'desc')->limit(5)->get();
        $total_supplied = Stock::where(['customer_id' => $customer->id, 'action' => 'export'])->sum('total');

        return view('control.customer', compact(['customer', 'capitals', 'total_capital', 'total_supplied', 'stocks']));
    }


    function customerLedgerIndex($customer_id)
    {
        $customer = Customer::findorfail($customer_id);
        $stocks = Stock::where(['customer_id' => $customer->id])->orderby('id', 'desc')->paginate(50);
        $total_capital = Stock::where(['customer_id' => $customer->id, 'action' => 'capital'])->sum('total');
        $total_supplied = Stock::where(['customer_id' => $customer->id, 'action' => 'export'])->sum('total');
        $balance = customerCredit($customer_id);

        return view('control.print_exporters_ledger', compact(['customer', 'stocks', 'total_capital', 'total_supplied', 'balance']));
    }

    function supplierLedgerIndex($customer_id)
    {
        $customer = Supplier::findorfail($customer_id);
        $stocks = Stock::where(['supplier_id' => $customer->id])->orderby('id', 'desc')->paginate(50);
        $total_capital = Stock::where(['supplier_id' => $customer->id, 'action' => 'capital'])->sum('total');
        $total_supplied = Stock::where(['supplier_id' => $customer->id, 'action' => 'import'])->sum('total');
        $balance = supplierCredit($customer_id);
        return view('control.print_exporters_ledger', compact(['customer', 'stocks', 'total_capital', 'total_supplied', 'balance']));
    }


    function customerBalanceIndex()
    {
        $customers = Customer::orderby('name', 'asc')->paginate(100);
        $total_credit = $total_debit = 0;

        $all_cus = Customer::orderby('name', 'asc')->get(['id']);

        foreach($all_cus as $cs){
            $sup_bal = customerCredit($cs->id);

            if($sup_bal > 0) {
                $total_debit += $sup_bal;
            }else {
                $total_credit +=  $sup_bal;
            }

        }


        foreach($customers as $cus) {
                       
            $cus->account_summary = $this->calculatePurchases($cus->id);
        }
        return view('control.customer_balance', compact(['customers', 'total_credit', 'total_debit']));
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
