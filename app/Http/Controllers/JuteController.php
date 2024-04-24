<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\JuteBag;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Validators;

class JuteController extends Controller
{


    function juteIndex()
    {
        $bags = JuteBag::orderby('id', 'desc')->paginate(50);
        
        $clients = Customer::get(['id', 'name', 'nick_name', 'company_name'])->toArray();
        $suppliers = Supplier::get(['id',  'name', 'nick_name', 'company_name'])->toArray();



        foreach($clients as $index => $client) {
            $clients[$index]['role'] = 'customer';
        }

        foreach($suppliers as $index => $supplier) {
            $suppliers[$index]['role'] = 'supplier';
        }

        $all_client = array_merge($clients, $suppliers);

        return view('control.jutebags', compact(['bags', 'all_client']));
    }


    function juteledger(Request $request)
    {

        $bags = JuteBag::where(['client_type' => $request->type, 'client_id' => $request->id])->orderby('id', 'desc')->paginate(50);


        if($request->type == 'customer') {
            $client = Customer::find($request->id);
        }else {
            $client = Supplier::find($request->id);
        }

        $client_type = $request->type; $client_id = $request->id;

        return view('control.juteledger', compact(['bags', 'client', 'client_type', 'client_id']));

    }


    function deleteBag($id)
    {
        JuteBag::where('id', $id)->delete();
        return back()->with('success', 'Jute bag transaction has been deleted');
    }


    function addJuteBags(Request $request)
    {
        Validator::make($request->all(), [
            'action' => 'required|string|min:3',
            'bags' => 'required|integer'
        ])->validate();

        $amount = -$request->bags;

        if($request->action == 'return' || $request->action == 'purchased'){
            $amount = abs($amount);
        }


        $client = json_decode($request->name);


        // return $client->id;

        $jute = JuteBag::create([
            'client_id' => $client->id,
            'client_type' => $client->role,
            'action' => $request->action,
            'amount' => $amount,
            'remark' => $request->remark,
            'added_by' => auth()->user()->id
        ]);

        $jute->update([
            'balance' => $this->jutebalance()
        ]);

        return back()->with('success', 'Jute bag transaction has been sucessfuly logged');
    }


    function jutebalance()
    {
        return JuteBag::sum('amount');
    }
}
