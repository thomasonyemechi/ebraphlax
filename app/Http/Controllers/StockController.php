<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Expenses;
use App\Models\Products;
use App\Models\Restock;
use App\Models\RestockSummary;
use App\Models\Sales;
use App\Models\SalesSummary;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;

class StockController extends Controller
{
    function restock(Request $request)
    {
    }

    function posIndex(Request $request)
    {
        if (!$request->trno) {
            return redirect('/control/pos?trno=' . rand(1111111, 999999999999));
        }


        // $suppliers = Supplier::orderby('name', 'asc')->get(['id', 'name', 'nick_name', 'company_name']);
        $customers = Customer::orderby('name', 'asc')->get(['id', 'name', 'nick_name', 'company_name']);
        // $customers = Cus::get(['id', 'name', 'nick_name', 'company_name']);


        $available_stock = Stock::where(['action' => 'import', 'product_id' => 1, ['bags', '>', 'bags_out']])->limit(100)->get();
        return view('control.new_pos', compact(['customers', 'available_stock']));
    }


    function clean_str($str)
    {
        if ($str) {
            $cleanStr = preg_replace('/[^A-Za-z0-9 ]/', '', $str);
            return $cleanStr;
        }
    }


    function searchItem(Request $request)
    {
        $items = Products::where('name', 'like', "%$request->s%")->limit(20)->get();
        foreach ($items as $item) {
            $item['quantity'] = itemQty($item->id);
            $item->name = $this->clean_str($item->name);
        }
        return response($items);
    }


    function calculatePrice($gross_weight, $discount, $bags, $type=1)
    {
        if ($type == 2) {
            return ($gross_weight / 1027);
        } else {
            return $gross_weight - ($discount + ($bags * 1.5));
        }
    }

    public function restockProduct(Request $request)
    {


        $supplier_id = $request->customer_id;
        $summary = RestockSummary::create([
            'warehouse_id' => 1,
            'user_id' => auth()->user()->id,
            'supplier_id' => $supplier_id,
            'total' => 0,
            'amount_paid' => $request->advance ?? 0
        ]);

        $cart_total = 0;





        $client = [
            'id' => $supplier_id,
            'user_type' => 'normal'
        ];

        $this->addStockExpense($request->expenses, $summary->id, $client, $request->action);

        $total_net_weight = 0;

        // return $request->items;

            foreach ($request->items as $item) {
                $price = $item['price'];
                $item_id = $item['id'];
                $gross_weight = $item['gross_weight'];
                $moisture_discount = $item['moisture_discount'];
                $bags = $item['bags'];
                $net_weight = $this->calculatePrice($item['gross_weight'], $moisture_discount, $bags, $item['type']);
                $item_total = $net_weight * $price;
                $total_net_weight += $net_weight;
                $cart_total += $item_total;


                $res = Restock::create([
                    'summary_id' => $summary->id,
                    'product_id' => $item_id,
                    'net_weight' => $net_weight,
                    'gross_weight' => $gross_weight,
                    'bags' => $bags,
                    'price' => $price,
                    'moisture_discount' => $moisture_discount
                ]);


                Stock::create([
                    'product_id' => $item_id,
                    'warehouse_id' => 1,
                    'net_weight' => $net_weight,
                    'gross_weight' => $gross_weight,
                    'customer_id' => 0,
                    'supplier_id' => $request->supplier_id,
                    'summary_id' => $res->id,
                    'price' => $price,
                    'bags' => $bags,
                    'total' => $item_total,
                    'action' => 'import',
                    'user_id' => auth()->user()->id,
                    'current_balance' => supplierCredit($supplier_id)
                ]);
            
        }

        $summary->update([
            'total' => $cart_total
        ]);

        return response([
            'message' => $total_net_weight . ' (kg) has been added to stock',
            'sales_id' => $summary->id,
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






    public function makeSales(Request $request)
    {
        $customer_id = $request->customer_id;
        $summary = SalesSummary::create([
            'warehouse_id' => 1,
            'user_id' => auth()->user()->id,
            'customer_id' => $customer_id,
            'total' => 0,
            'amount_paid' => $request->advance ?? 0,
            'lorry_number' => $request->lorry_number
        ]);

        $cart_total = 0;





        $client = [
            'id' => $customer_id,
            'user_type' => 'normal'
        ];

        $this->addStockExpense($request->expenses, $summary->id, $client, $request->action);

        $total_net_weight = 0;


            foreach ($request->items as $item) {
                $price = $item['price'];
                $item_id = $item['id'];
                $gross_weight = $item['gross_weight'];
                $moisture_discount = $item['moisture_discount'];
                $bags = $item['bags'];
                $net_weight = $this->calculatePrice($item['gross_weight'], $moisture_discount, $bags, $item['type']);
                $item_total = $net_weight * $price;
                $total_net_weight += $net_weight;
                $cart_total += $item_total;


                $res = Sales::create([
                    'summary_id' => $summary->id,
                    'product_id' => $item_id,
                    'net_weight' => $net_weight,
                    'gross_weight' => $gross_weight,
                    'bags' => $bags,
                    'price' => $price,
                    'moisture_discount' => $moisture_discount
                ]);


                $last_stock = Stock::create([
                    'product_id' => $item_id,
                    'warehouse_id' => 1,
                    'net_weight' => -$net_weight,
                    'gross_weight' => -$gross_weight,
                    'customer_id' => $customer_id,
                    'supplier_id' => 0,
                    'summary_id' => $res->id,
                    'price' => $price,
                    'bags' => -$bags,
                    'total' => $item_total,
                    'action' => 'export',
                    'user_id' => auth()->user()->id,
                    'current_balance' => customerCredit($customer_id)
                ]);
            }
        

        $summary->update([
            'total' => $cart_total,
        ]);

        return response([
            'message' => $total_net_weight . ' (kg) has been exported',
            'sales_id' => $summary->id,
            'status' => true
        ]);
    }
}
