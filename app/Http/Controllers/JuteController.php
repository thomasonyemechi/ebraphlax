<?php

namespace App\Http\Controllers;

use App\Models\JuteBag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Validators;

class JuteController extends Controller
{


    function juteIndex()
    {
        $bags = JuteBag::orderby('id', 'desc')->paginate(50);
        return view('control.jutebags', compact(['bags']));
    }


    function deleteBag($id)
    {
        JuteBag::where('id', $id)->delete();
        return back()->with('success', 'Jute bag transaction has been deleted');
    }


    function addJuteBags(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'action' => 'required|string|min:3',
            'bags' => 'required|integer'
        ])->validate();

        $amount = -$request->bags;

        if($request->action == 'return' || $request->action == 'purchased'){
            $amount = abs($amount);
        }

        $jute = JuteBag::create([
            'name' => $request->name,
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
