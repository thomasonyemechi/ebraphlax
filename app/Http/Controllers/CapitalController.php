<?php

namespace App\Http\Controllers;

use App\Models\Capital;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CapitalController extends Controller
{
    function addCapital(Request $request)
    {
        Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'amount' => 'required|integer',
            'narration' => 'required|string'
        ])->validate();

       $capital = Stock::create([
            'user_id' => auth()->user()->id,
            'total' => $request->amount,
            'action' => 'capital',
            'remark' => $request->narration,
        ]);


        if($request->action == 'import') {
            $capital->update([
                'supplier_id' => $request->user_id,
                'current_balance' => supplierCredit($request->user_id)
            ]);
        }else {
            $capital->update([
                'customer_id' => $request->user_id,  
                'current_balance' => customerCredit($request->user_id)
            ]); 
        }


        

        return back()->with('success', 'Capital has been assigned to this client');
    }



    function removeCapital($capital_id)
    {
        Capital::where('id', $capital_id)->delete();
        return back()->with('success', 'Capital has been removed from this account');
    }
}
