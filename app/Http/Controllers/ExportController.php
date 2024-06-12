<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Export;
use App\Models\Products;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExportController extends Controller
{

    function addExportIndex(Request $request)
    {
        $stocks = Stock::where('action', 'client_export')->orwhere('action', 'like', '%adjustment%')->where('customer_id', '>', 0)->orderby('id', 'desc')->paginate(100);
        $clients = Customer::orderby('name','asc')->get(['id', 'name', 'nick_name']);
        $products = Products::orderby('id', 'asc')->get();


        $selected_stock = 0;
        if($request->edit) {
            $selected_stock = Stock::find($request->edit);
        }


        return view('control.make_export_ledger', compact(['products', 'clients', 'stocks', 'selected_stock']));
    }
    function addExport(Request $request)
    {
        Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'exporter' => 'required|string|exists:customers,id', 
            'bags' => 'required',
            'net_weight' => 'required',
            'gross_weight' => 'required',
            'price' => 'required',
            'rate' => 'required',
            'tares' => 'required',
            'total' => 'required',
        ])->validate();

        
        $res = Export::create([
            'product_id' => $request->product_id,
            'net_weight' => $request->net_weight,
            'gross_weight' => $request->gross_weight,
            'bags' => $request->bags,
            'tares' => $request->tares,
            'rate' => $request->rate,
            'price' => $request->price,
            'moisture_discount' => $request->moisture_discount ?? 0,
            'customer_id' => $request->exporter,
            'user_id' => auth()->user()->id,
            'total' => ($request->total),
        ]);


        $stock = Stock::create([
            'product_id' => $request->product_id,
            'warehouse_id' => 1,
            'net_weight' => $request->net_weight,
            'gross_weight' => $request->gross_weight,
            'customer_id' => 0,
            'customer_id' => $request->exporter,
            'summary_id' => $res->id,
            'price' => $request->price,
            'bags' => $request->bags,
            'tares' => $request->tares,
            'total' => ($request->total),
            'action' => 'client_export',
            'moisture_discount' => $request->moisture_discount ?? 0,
            'user_id' => auth()->user()->id,
        ]);

        $stock->update([
            'current_balance' => customerCredit($request->exporter)
        ]);


        return back()->with('success', 'Exported transaction has been added to exporters ledger');
    }



    function updateExport(Request $request)
    {
        Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'exporter' => 'required|string|exists:customers,id', 
            'bags' => 'required',
            'net_weight' => 'required',
            'gross_weight' => 'required',
            'price' => 'required',
            'rate' => 'required',
            'tares' => 'required',
            'total' => 'required',
            'stock_id' => 'required|exists:stocks,id'
        ])->validate();


        $stock = Stock::find($request->stock_id);


        
        Export::where('id', $stock->summary_id)->update([
            'product_id' => $request->product_id,
            'net_weight' => $request->net_weight,
            'gross_weight' => $request->gross_weight,
            'bags' => $request->bags,
            'tares' => $request->tares,
            'rate' => $request->rate,
            'price' => $request->price,
            'moisture_discount' => $request->moisture_discount ?? 0,
            'customer_id' => $request->exporter,
            'user_id' => auth()->user()->id,
            'total' => ($request->total),
        ]);


        $stock->update([
            'product_id' => $request->product_id,
            'warehouse_id' => 1,
            'net_weight' => $request->net_weight,
            'gross_weight' => $request->gross_weight,
            'customer_id' => 0,
            'customer_id' => $request->exporter,
            'price' => $request->price,
            'bags' => $request->bags,
            'tares' => $request->tares,
            'total' => ($request->total),
            'moisture_discount' => $request->moisture_discount ?? 0,
            'user_id' => auth()->user()->id,
        ]);

        $stock->update([
            'current_balance' => customerCredit($request->exporter)
        ]);


        return redirect('/control/make_export_ledger')->with('success', 'Exported transaction updated');
    }



    public function deleteExport($stock_id)
    {
        $stock = Stock::find($stock_id);

        Export::where('id', $stock->summary_id)->delete();
        $stock->delete();

        return back()->with('success', 'Export transaction has been deleted');
    }
}
