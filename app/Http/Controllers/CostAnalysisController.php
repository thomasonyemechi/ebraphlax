<?php

namespace App\Http\Controllers;

use App\Models\Cstock;
use App\Models\Products;
use App\Models\Restock;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CostAnalysisController extends Controller
{
    function coostanalysisIndex()
    {
        $products = Products::orderby('name', 'asc')->get();
        foreach($products as $product) {
            $product->stock_weight = $this->productWeight($product->id);
            $product->stock_bag = $this->productBags($product->id);
        }

        $clients = Supplier::orderby('name','asc')->get(['id', 'name', 'nick_name']);
        $stocks = Stock::where('action', 'import')->orWhere('action', 'export')->orderby('id', 'desc')->paginate(100);
        return view('control.manage_stock', compact(['products', 'stocks', 'clients']));
    }


    function generalStockLedgerIndex($product_id)
    {
        $product = Products::findorfail($product_id);
        $stocks = Cstock::where(['product_id' => $product_id])->orderby('id', 'desc')->paginate(100);

        $total_stock = Cstock::where(['product_id' => $product_id])->count();
        $total_in = Cstock::where(['product_id' => $product_id, ['bag', '>', 0 ]])->count();
        $bag_balance = $this->productBags($product->id);
        $weight_balance = $this->productWeight($product->id);
        return view('control.general_stock_legder', compact(['product', 'stocks', 'bag_balance', 'weight_balance', 'total_stock', 'total_in']));
    }



    function addStocks(Request $request)
    {

        Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'supplier' => 'required|string|exists:suppliers,id', 
            'bags' => 'required',
            'net_weight' => 'required',
            'gross_weight' => 'required',
            'price' => 'required',
            'rate' => 'required',
            'tares' => 'required',
        ])->validate();

        
        $res = Restock::create([
            
            'product_id' => $request->product_id,
            'net_weight' => $request->net_weight,
            'gross_weight' => $request->gross_weight,
            'bags' => $request->bags,
            'tares' => $request->tares,
            'rate' => $request->rate,
            'price' => $request->price,
            'moisture_discount' => $request->moisture_discount ?? 0,
            'supplier_id' => $request->supplier,
            'user_id' => auth()->user()->id,
            'amount_paid' => $request->amount_paid,
            'total' => ($request->price * $request->net_weight),
        ]);


        $stock = Stock::create([
            'product_id' => $request->product_id,
            'warehouse_id' => 1,
            'net_weight' => $request->net_weight,
            'gross_weight' => $request->gross_weight,
            'customer_id' => 0,
            'supplier_id' => $request->supplier,
            'summary_id' => $res->id,
            'price' => $request->price,
            'bags' => $request->bags,
            'tares' => $request->tares,
            'total' => ($request->price * $request->net_weight),
            'action' => 'import',
            'moisture_discount' => $request->moisture_discount ?? 0,
            'user_id' => auth()->user()->id,
            'amount_paid' => $request->amount_paid,
            'current_balance' => supplierCredit($request->supplier_id)
        ]);

        $stock->update([
            'bag_balance' => $this->productBags($request->product_id),
            'weight_balance' => $this->productWeight($request->product_id),
        ]);


        return back()->with('success', 'Stock has been sucessfuly updated');
    }


    function deleteStock($id)
    {
        Cstock::where('id', $id)->delete();
        return back()->with('success', 'Stock has been sucessfuly deleted');
    }

}
