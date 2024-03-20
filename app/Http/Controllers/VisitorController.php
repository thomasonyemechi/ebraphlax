<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VisitorController extends Controller
{
    function visitorIndex()
    {
        if(auth()->user()->role == 'administrator') {
            $visitors = Visitor::orderby('id', 'desc')->paginate(25);
        }else {
            $visitors = Visitor::where(['added_by' => auth()->user()->id ])->orderby('id', 'desc')->paginate(25);
        }
        return view('control.visitors', compact(['visitors']));
    }



    function addVisist(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'reason' => 'required|string|min:3'
        ])->validate();

        Visitor::create([
            'name' => $request->name,
            'reason' => $request->reason,
            'time_in' => time(),
            'added_by' => auth()->user()->id
        ]);

        return back()->with('success', 'Visit has been sucessfuly logged');
    }

    function updateVisit(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'reason' => 'required|string|min:3',
            'visit_id' => 'required|exists:visitors,id'
        ])->validate();

        Visitor::where('id', $request->visit_id)->update([
            'name' => $request->name,
            'reason' => $request->reason,
            'time_in' => time(),
        ]);

        return back()->with('success', 'Visit has been sucessfuly updated');
    }


    function updateTimeOut($id) 
    {
        Visitor::where('id', $id)->update([
            'time_out' => time()
        ]);

        return back()->with('success', 'Time out has been updated');
    }



    function deleteVisit($id)
    {
        Visitor::where(['id' => $id])->delete();
        return back()->with('success', 'Log has been sucessfuly deleted');
    }
}
