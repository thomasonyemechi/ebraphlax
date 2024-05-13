<?php

namespace App\Http\Controllers;

use App\Models\Cstock;
use App\Models\Expenses;
use App\Models\Products;
use App\Models\Restock;
use App\Models\Sales;
use App\Models\SalesSummary;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CostAnalysisController extends Controller
{
    function coostanalysisIndex(Request $request)
    {
        $products = Products::orderby('id', 'asc')->get();
        foreach($products as $product) {
            $product->stock_weight = $this->productWeight($product->id);
            $product->stock_bag = $this->productBags($product->id);
        }


        $selected_stock = 0;
        if($request->edit) {
            $selected_stock = Stock::find($request->edit);
        }


        $clients = Supplier::orderby('name','asc')->get(['id', 'name', 'nick_name']);
        $stocks = Stock::where('action', 'import')->orderby('id', 'desc')->paginate(100);
        return view('control.manage_stock', compact(['products', 'stocks', 'clients', 'selected_stock']));
    }




    function generalStockLedgerIndex($product_id)
    {
        $product = Products::findorfail($product_id);
        $stocks = Stock::where(['product_id' => $product_id,])->orderby('id', 'desc')->paginate(100);

        $total_stock = Stock::where(['product_id' => $product_id])->count();
        $total_in = Stock::where(['product_id' => $product_id, ['bags', '>', 0 ]])->count();
        $bag_balance = $this->productBags($product->id);
        $weight_balance = $this->productWeight($product->id);
        return view('control.general_stock_legder', compact(['product', 'stocks', 'bag_balance', 'weight_balance', 'total_stock', 'total_in']));
    }



    function adjustment(Request $request)
    {
        
        Validator::make($request->all(), [
            'adjustment' => 'required',
            'change_value' => 'required', 
        ])->validate();


        $ex_stock = Stock::find($request->stock_id);





        $stock = Stock::create([
            'product_id' => $ex_stock->product_id,
            'warehouse_id' => 1,
            'supplier_id' => $ex_stock->supplier_id,
            'summary_id' => $ex_stock->id,
            'price' => $ex_stock->price,
            'total' => $request->adjustment_total,
            'action' => 'adjustment',
            'user_id' => auth()->user()->id,
        ]);

        if($request->adjustment == 'mositure')
        {
            $stock->update([
                'action' => 'moisture adjustment',
                'moisture_discount' => $request->change_value,
            ]);
        }elseif($request->adjustment == 'price')
        {
            $stock->update([
                'action' => 'price adjustment',
                'price' => $request->change_value,
            ]);
        }


        $stock->update([
            'current_balance' => supplierCredit($request->supplier)
        ]);


        return back()->with('success', 'Adjustment has been succesfuly submited'); 
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
        ]);

        $stock->update([
            'bag_balance' => $this->productBags($request->product_id),
            'weight_balance' => $this->productWeight($request->product_id),
            'current_balance' => supplierCredit($request->supplier)
        ]);

        $product = Products::find($request->product_id);

        $body  = 'We have received a supply of '.$request->bags.' bags of '.$product->name .' ('.$request->net_weight.' kg) from you at '. money($request->price) .' per kg for total of '.(money($request->price * $request->net_weight)).' thanks' ;
        $to = Supplier::find($request->supplier);
        $to = $to->phone;
        $this->sendSms($body, $to);

        return back()->with('success', 'Stock has been sucessfuly updated');
    }



    function editStockTransaction (Request $request)
    {
        
        Validator::make($request->all(), [
            'stock_id' => 'required|exists:stocks,id',
            'product_id' => 'required|exists:products,id',
            'supplier' => 'required|string|exists:suppliers,id', 
            'bags' => 'required',
            'net_weight' => 'required',
            'gross_weight' => 'required',
            'price' => 'required',
            'rate' => 'required',
            'tares' => 'required',
        ])->validate();

        $stock = Stock::find($request->stock_id);

        
        $res = Restock::where('id', $stock->summary_id)->update([
            'product_id' => $request->product_id,
            'net_weight' => $request->net_weight,
            'gross_weight' => $request->gross_weight,
            'bags' => $request->bags,
            'tares' => $request->tares,
            'rate' => $request->rate,
            'price' => $request->price,
            'moisture_discount' => $request->moisture_discount ?? 0,
            'supplier_id' => $request->supplier,
            'amount_paid' => $request->amount_paid,
            'total' => ($request->price * $request->net_weight),
        ]);


        $stock->update([
            'product_id' => $request->product_id,
            'warehouse_id' => 1,
            'net_weight' => $request->net_weight,
            'gross_weight' => $request->gross_weight,
            'customer_id' => 0,
            'supplier_id' => $request->supplier,
            'price' => $request->price,
            'bags' => $request->bags,
            'tares' => $request->tares,
            'total' => ($request->price * $request->net_weight),
            'action' => 'import',
            'moisture_discount' => $request->moisture_discount ?? 0,
            'user_id' => auth()->user()->id,
            'amount_paid' => $request->amount_paid,
        ]);

        $stock->update([
            'bag_balance' => $this->productBags($request->product_id),
            'weight_balance' => $this->productWeight($request->product_id),
            'current_balance' => supplierCredit($request->supplier)
        ]);

        $product = Products::find($request->product_id);

        // $body  = 'We have received a supply of '.$request->bags.' bags of '.$product->name .' ('.$request->net_weight.' kg) from you at '. money($request->price) .' per kg for total of '.(money($request->price * $request->net_weight)).' thanks' ;
        // $to = Supplier::find($request->supplier);
        // $to = $to->phone;
        // $this->sendSms($body, $to);

        return redirect('/control/manage-stock')->with('success', 'Stock transaction has been sucessfuly updated');
    }

    function deleteStock($id)
    {
        Cstock::where('id', $id)->delete();
        return back()->with('success', 'Stock has been sucessfuly deleted');
    }


    function deleteStockAccount($id)
    {
        Stock::where('id', $id)->delete();
        return back()->with('success', 'Stock has been sucessfuly deleted');
    }



    function calculateNetWeight($gross_weight, $discount, $rate, $tares, $type = 1) {
        if ($type == 2) {
            $net_weight = ($gross_weight / $rate) * 1000;
            return $net_weight;
        } else {
            return ($gross_weight - $discount) - $tares;
        }
    }



    public function makeSales(Request $request)
    {
        $customer_id = $request->customer_id;
        $summary = SalesSummary::create([
            'warehouse_id' => 1,
            'user_id' => auth()->user()->id,
            'customer_id' => $customer_id,
            'total' => $request->total,
            'amount_paid' => $request->advance ?? 0,
            'lorry_number' => $request->lorry_number,
            'sales_price' => $request->sales_price
        ]);
  
        $total_net_weight = 0; $bags_total = 0;


        foreach ($request->items as $item) {
            $price = $item['price'];
            $intial_stock = Stock::find($item['stock_id']);
            $product_id = $intial_stock->product_id;
            $bags = $item['bags'];
            $tares = $item['tares'];
            $moisture_discount = $item['moisture_discount'];
            $net_weight = $item['net_weight'];

            $bags_total += $bags;
            $item_total = $net_weight * $price;
            $total_net_weight += $net_weight;

            $stock = Stock::create([
                'product_id' => $product_id,
                'warehouse_id' => 1,
                'net_weight' => $net_weight,
                'customer_id' => $request->customer_id,
                'summary_id' => $summary->id,
                'price' => $price,
                'bags' => $bags,
                'total' => $item_total,
                'tares' => $tares,
                'moisture_discount' => $moisture_discount,
                'action' => 'export',
                'user_id' => auth()->user()->id,
                'amount_paid' => $request->advance ?? 0,
                'remark' => $item['stock_id']
            ]);
    
            $stock->update([
                'bag_balance' => $this->productBags($request->product_id),
                'weight_balance' => $this->productWeight($request->product_id),
                'current_balance' => customerCredit($request->customer_id),
            ]);


            $bags_out = $intial_stock->bags_out;
            $weight_out = $intial_stock->weight_out;
            $intial_stock->update([
                'bags_out' => ($bags_out + $bags),
                'weight_out' => ($weight_out + $net_weight)
            ]);    
        }



        if ($request->expenses) {
            foreach ($request->expenses as $expense) {
                $stock = Stock::create([
                    'remark' => $expense['title'],
                    'total' => $expense['amount'],
                    'customer_id' => $request->customer_id,
                    'action' => 'expenses',
                    'user_id' => auth()->user()->id,
                ]);
            }
        }

        $customer = Customer::find($customer_id);

        $body  = 'A supply of  '.$bags_total.' bags of '.$intial_stock->product->name .' ('.$total_net_weight.' kg) is been supplied to you at '.$request->sales_price.' per kg, LORRY NUMBER '.$request->lorry_number.' thanks' ;
       
        $this->sendSms($body, $customer->phone, );


        return response([
            'message' => $total_net_weight . ' (kg) has been exported',
            'status' => true
        ]);
    }



    function addStockExpense($expenses, $summary_id, $client, $action)
    {
        if ($expenses) {
            foreach ($expenses as $expense) {
                Expenses::create([
                    'category_id' => 1,
                    'client_id' => $client['id'],
                    'user_type' => $client['user_type'],
                    'summary_id' => $summary_id,
                    'amount' => $expense['amount'],
                    'remark' => $expense['title'],
                    'added_by' => auth()->user()->id,
                    'type' => $action,
                ]);
            }
        }
        return;
    }




    function stockStock()
    {
        $products = Products::orderby('id', 'asc')->get();
        foreach($products as $product) {
            $product->stock_weight = $this->stockWeight($product->id);
            $product->stock_bag = $this->stockBags($product->id);
        }

        $suppliers = Supplier::orderby('name','asc')->get(['id', 'name', 'nick_name', 'phone']);
        $customers = Customer::orderby('name','asc')->get(['id', 'name', 'nick_name', 'phone']);
        $stocks = Cstock::orderby('id', 'desc')->paginate(100);
        return view('control.manage_stock_2', compact(['products', 'stocks', 'suppliers', 'customers']));   
    }



    function addToStockeStoreKeeper(Request $request)
    {

        Validator::make($request->all(), [
            'action' => 'required|string', 
            'product_id' => 'required|exists:products,id',
            'bags' => 'required', 
            'weight' => 'required'
        ])->validate();

        $client_id = 0;

        if($request->action == 'import') {
            Validator::make($request->all(), [
                'supplier_id' => 'required|exists:suppliers,id',
            ])->validate();

            $client_id = $request->supplier_id;
        }else {
            Validator::make($request->all(), [
                'customer_id' => 'required|exists:customers,id',
            ])->validate(); 
            
            $client_id = $request->customer_id;
        }

        $bags = $request->bags; $weight = $request->weight;

        if($request->action == 'export'){
            $bags = -$bags; $weight = -($weight);
        }

        $stock = Cstock::create([
            'warehouse_id' => 1,
            'product_id' => $request->product_id,
            'client_id' => $client_id,
            'action' => $request->action, 
            'bags' => $bags,
            'weight' => $weight,
            'status' => 1,
            'user_id' => auth()->user()->id
        ]);

        $stock->update([
            'bag_balance' => $this->stockBags($request->product_id), 
            'weight_balance' => $this->stockWeight($request->product_id)
        ]);
        return back()->with('success', 'Stock has been recorded');
    }


    function deleteStockeStoreKeeper($id)
    {
        $stock = Cstock::find($id);
        if($stock->user_id == auth()->user()->id) {
            $stock->delete();
            return back()->with('success', 'Stock record has been deleted sucessfully');
        }
        return back()->with('error', 'You cannot delete this transaction');
    }

    

    function generalStockLedgerIndex2($product_id)
    {
        $product = Products::findorfail($product_id);
        $stocks = Cstock::where(['product_id' => $product_id])->orderby('id', 'desc')->paginate(100);

        $total_stock = Cstock::where(['product_id' => $product_id])->count();
        $total_in = Cstock::where(['product_id' => $product_id, ['bags', '>', 0 ]])->count();
        $bag_balance = $this->StockBags($product->id);
        $weight_balance = $this->StockWeight($product->id);
        return view('control.manage_stock_ledger', compact(['product', 'stocks', 'bag_balance', 'weight_balance', 'total_stock', 'total_in']));
    }





        
    function stockBags($product_id)
    {
        $total_bags = Cstock::where(['product_id' => $product_id])->sum('bags');
        return $total_bags;
    }

    function stockWeight($product_id)
    {
        $total_bags = Cstock::where(['product_id' => $product_id])->sum('weight');
        return $total_bags;
    }

}
