<?php

namespace App\Http\Controllers;

use App\Models\JuteBag;
use App\Models\SalesSummary;
use App\Models\Stock;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    function DailyReport(Request $request)
    {

        $date = ($request->date) ? date('y-m-d' ,strtotime($request->date)) : date('y-m-d');


        $transactions = Stock::whereDate('created_at', '=', $date)->paginate(50);

        $total_invoice = Stock::whereDate('created_at', '=', $date)->count();
        $exports = Stock::where(['action' => 'export'])->whereDate('created_at', '=', $date)->count();
        $total_sales = Stock::where([ 'action' => 'export'])->whereDate('created_at', '=', $date)->sum('total');
        $money_in = Stock::where(['action' => 'export'])->whereDate('created_at', '=', $date)->sum('amount_paid');


        $capital_received = Stock::where(['action' => 'capital', 'supplier_id' => 0])->whereDate('created_at', '=', $date)->sum('total');
        $capital_given = Stock::where(['action' => 'capital', 'customer_id' => 0])->whereDate('created_at', '=', $date)->sum('total');


        $bags_in = Stock::where(['action' => 'import'])->whereDate('created_at', '=', $date)->sum('bags');
        $bags_out = Stock::where(['action' => 'export'])->whereDate('created_at', '=', $date)->sum('bags');


        
        $weight_in = Stock::where(['action' => 'import'])->whereDate('created_at', '=', $date)->sum('net_weight');
        $weight_out = Stock::where(['action' => 'export'])->whereDate('created_at', '=', $date)->sum('net_weight');

        $jute_out = JuteBag::where(['action' => 'store use'])->orWhere('action', 'advance')->whereDate('created_at', '=', $date)->sum('amount');
        $jute_in = JuteBag::where(['action' => 'return'])->orWhere('action', 'purchased')->whereDate('created_at', '=', $date)->sum('amount');




        $today_sales = SalesSummary::with(['sales'])->whereDate('created_at', '=', $date)->get();

        return view('control.daily_report',compact([
            'transactions', 'date', 'total_invoice', 'exports', 'total_sales', 'money_in', 'today_sales', 'capital_given', 'capital_received', 'bags_out', 'bags_in',
            'weight_in', 'weight_out', 'jute_in', 'jute_out'
        ]));
    }
}
