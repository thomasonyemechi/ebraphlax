<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\Expenses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    function expensesIndex()
    {
        return view('control.expense_overview');
    }



    function addIndex()
    {
        $categories = ExpenseCategory::all();
        $expenses = Expenses::with(['category', 'user'])->orderby('id', 'desc')->paginate(25);
        return view('control.expense', compact(['categories', 'expenses']) );
    }


    function addExpensesCategory(Request $request)
    {
        Validator::make($request->all(), [
            'category_name' => 'required|string|min:3|unique:expenses_categories,title',
            'description' => 'string'
        ])->validate();

        ExpenseCategory::create([
            'title' => $request->category_name,
            'description' => $request->description,
            'user_id' => auth()->user()->id
        ]);
        return back()->with('success', 'Expenses category has been added');
    }


    function createExpense(Request $request)
    {
        Validator::make($request->all(), [
            'category_id' => 'required|exists:expenses_categories,id',
            'amount' => 'required|integer',
            'remark' => 'string'
        ])->validate();

        Expenses::create([
            'amount' => $request->amount,
            'expenses_category_id' => $request->category_id,
            'remark' => $request->remark,
            'user_id' => auth()->user()->id
        ]);

        return back()->with('success', 'Expense has been added');

    }


    function deleExpenseCategory(Request $request, $id)
    {


        /////check if expense exist in expense table 
        $check = Expenses::where(['expenses_category_id' => $id])->limit(1)->count();

        if($check > 0) {
            return back()->with('error', 'This category cannot be deleted');
        }

        ExpenseCategory::where('id', $request->id)->delete();
        
        return back()->with('success', 'Expense category has been deleted');
    }

}
