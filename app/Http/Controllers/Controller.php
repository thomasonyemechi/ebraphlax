<?php

namespace App\Http\Controllers;

use App\Models\Cstock;
use App\Models\Customer;
use App\Models\Expenses;
use App\Models\Products;
use App\Models\Sms;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function dashboardIndex()
    {
        $total_customer = Customer::count();
        $total_supplier = Supplier::count();
        $total_product = Products::count();
        $total_sales = Stock::where('action', 'export')->count();
        $total_import = Stock::where('action', 'import')->count();
        $sales_amount = Stock::where('action', 'export')->sum('total');
        $total_expenses = Stock::where(['action' => 'expenses'])->count();
        $expenses_amount = Stock::where(['action' => 'expenses'])->count();
        $total_stock = Stock::count();
        $invoice_by_you = Stock::where(['user_id' => auth()->user()->id])->count();
        $sales_by_you = Stock::where(['user_id' => auth()->user()->id, 'action' => 'export'])->sum('total');
        $stocks = Stock::orderby('id', 'desc')->limit(10)->get();
        return view('control.index', compact([
            'total_customer', 'total_supplier', 'total_product', 'total_sales', 'sales_amount', 'total_expenses', 'expenses_amount', 'total_stock'
            ,'invoice_by_you', 'sales_by_you', 'total_import', 'stocks'
        ]));
    }



    
    function sendSms($body, $to, $from = "")
    {

        $from = ($from == "") ? env('SMS_DEFAULT_SENDER') : $from;

        $sms = Sms::create([
            'phone' => $to,
            'message' => $body,
            'sent_by' => auth()->user()->id ?? 1 
        ]);

        $res = Http::asForm()->post(env('SMS_ENDPOINT'), [
            'from' => $from,
            'to' => $to,
            'body' => $body,
            'api_token' => env("SMS_API_TOKEN"),
            'gateway' => '1',
            'append_sender' => env('SMS_DEFAULT_SENDER')
        ]);

        $res = json_decode($res);

        if(isset($res->data->status)) {
              if($res->data->status == 'success') {
            $sms->update([
                'status' => $res->data->status ?? 'Message has been sucessgully sent'
            ]);
              }
        }else {
            $sms->update([
                'status' => $res->data->status ?? 'Message was not sent'
            ]);    
        }

    
        return $res;
    }

    
    function productBags($product_id)
    {
        $total_bags = Stock::where(['product_id' => $product_id])->sum('bags');
        return $total_bags;
    }

    function productWeight($product_id)
    {
        $total_bags = Stock::where(['product_id' => $product_id])->sum('net_weight');
        return $total_bags;
    }



    public function seeeeend()
    {
        $this->sendSms('Soem sms has been sent to you', 9038772366, 'Ralphlak Aco');
        return 'done';
    }

}
