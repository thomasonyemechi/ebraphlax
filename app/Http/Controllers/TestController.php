<?php

namespace App\Http\Controllers;

use App\Models\Capital;
use App\Models\Cstock;
use App\Models\Customer;
use App\Models\Expenses;
use App\Models\JuteBag;
use App\Models\Products;
use App\Models\Restock;
use App\Models\RestockSummary;
use App\Models\Sales;
use App\Models\SalesSummary;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    function runUsers()
    {
        return;
        $faker = Faker::create();

        for ($i = 0; $i <= 10; $i++) {
            $role = $faker->randomElement(['administrator', 'store-keper', 'accountant']);


            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make(1234),
                'role' => $role,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address
            ]);
        }
    }




    function runSuppliers()
    {
        return;
        $faker = Faker::create();

        for ($i = 0; $i <= 72; $i++) {
            $role = $faker->randomElement(['administrator', 'store-keper', 'accountant']);

            Supplier::create([
                'name' => $faker->name,
                'company_name' => $faker->company,
                'nick_name' => $faker->name,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address
            ]);
        }
    }


    
    function fakeVisit()
    {
        return;
        $staffs = User::pluck('id')->toArray();

        $faker = Faker::create();


        for ($i = 0; $i <= 44; $i++) {
            Visitor::create([
                'name' => $faker->name,
                'reason' => $faker->sentence(20),
                'time_in' => time(),
                'time_out' =>  time() + (rand(3, 20) * 60),
                'added_by' => $faker->randomElement($staffs),
            ]);
        }

        return 'done';
    }


    function fakeBags()
    {
        return;
        $faker = Faker::create();
        $users = User::pluck('id')->toArray();

        for ($i = 0; $i <= 65; $i++) {
       
            $amount = -$faker->numberBetween(10,100);
            $action = $faker->randomElement(['return', 'advance', 'store user', 'purchased']);

            if($action == 'return' || $action == 'purchased'){
                $amount = abs($amount);
            }
    
            $jute = JuteBag::create([
                'name' => $faker->name,
                'action' => $action,
                'amount' => $amount,
                'remark' => $faker->sentence(5),
                'added_by' =>  $faker->randomElement($users),
            ]);
    
            $jute->update([
                'balance' => JuteBag::sum('amount')
            ]);            
        }

        return 'done';
    }



    function fakeStock()
    {

        $faker = Faker::create();
        $users = User::pluck('id')->toArray();
        $products = Products::pluck('id')->toArray();

        for ($i = 0; $i <= 1234; $i++) {

            $action = $faker->randomElement(['stock in', 'stock out']);
            $bags = -$faker->numberBetween(1, 100); 
            $weight = -$bags * -rand(60, 70);
            $product =  $faker->randomElement($products);

            if($action == 'stock in') {
                $bags = abs($bags); $weight = abs($weight);
            }


            // return $weight;
    
            $stock = Cstock::create([
                'product_id' => $product,
                'warehouse_id' => 1,
                'client_name' => $faker->name,
                'bag' => $bags,
                'weight' => $weight,
                'user_id' =>  $faker->randomElement($users)
            ]);
    
    
            $stock->update([
                'bag_balance' => $this->productBags($product),
                'weight_balance' => $this->productWeight($product),
            ]);

            

        }



        return 'done';

    }


    function runCustomers()
    {
        return;
        $faker = Faker::create();

        for ($i = 0; $i <= 250; $i++) {
            $type = $faker->randomElement(['normal', 'advance']);
            $users = User::pluck('id')->toArray();
            Customer::create([
                'name' => $faker->name,
                'company_name' => $faker->company,
                'nick_name' => $faker->name,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'added_by' => $faker->randomElement($users),
            ]);
        }
    }




    // function fakerImport()
    // {
    //     return;

    //     $suppliers = Supplier::pluck('id')->toArray();
    //     $staffs = User::pluck('id')->toArray();
    //     $products = Products::pluck('id')->toArray();

    //     $faker = Faker::create();

        

    //     for ($j = 0; $j <= 234 ; $j++) {

    //         $c_user = $faker->randomElement($staffs);
    //         $items = [];
    //         $expenses = [];

    //         $ii_end = $faker->numberBetween(0, 6);

    //         for ($i = 0; $i <= $ii_end; $i++) {
    //             $product = $faker->randomElement($products);
    //             $product = Products::find($product);
    //             $net_weight = $faker->numberBetween(100, 1000);
    //             $items[] = [
    //                 'id' => $product->id,
    //                 'bags' => $faker->randomDigit(),
    //                 'name' => 'Cocoa',
    //                 'price' => $product->price,
    //                 'gross_weight' => $net_weight * 1.2,
    //                 'net_weight' => $net_weight,
    //                 'moisture_discount' => $faker->numberBetween(0, 20),
    //                 'final_weight' =>  $net_weight,
    //             ];
    //         }


    //         for ($i = 0; $i <= $faker->numberBetween(0, 6); $i++) {
    //             $amount = $faker->numberBetween(100, 30000);
    //             $expenses[] = [
    //                 'title' => $faker->word,
    //                 'amount' => $amount,
    //             ];
    //         }

    //         $request = [
    //             'customer_id' => $faker->randomElement($suppliers),
    //             'expenses' => $expenses,
    //             'items' => $items,
    //             'advance' => 0,
    //             'action' => 'import'

    //         ];

    //         $request = json_encode($request);
    //         $request = json_decode($request);




    //         $supplier_id = $request->customer_id;
    //         $summary = RestockSummary::create([
    //             'warehouse_id' => 1,
    //             'user_id' => $c_user,
    //             'supplier_id' => $supplier_id,
    //             'total' => 0,
    //             'amount_paid' => $request->advance ?? 0
    //         ]);

    //         $cart_total = 0;





    //         $client = [
    //             'id' => $supplier_id,
    //             'user_type' => 'normal'
    //         ];

    //         $this->addStockExpense($request->expenses, $summary->id, $client, $request->action);

    //         $total_net_weight = 0;

    //         // return $request->items;

    //         if (count($request->items) > 0) {
    //             foreach ($request->items as $item) {
    //                 $item = (array) $item;
    //                 $price = $item['price'];
    //                 $item_id = $item['id'];
    //                 $net_weight = $item['net_weight'];

    //                 $total_net_weight += $net_weight;

    //                 $gross_weight = $item['gross_weight'];
    //                 $moisture_discount = $item['moisture_discount'];
    //                 $bags = $item['bags'];
    //                 $item_total = $this->calculatePrice($net_weight, $price, $moisture_discount);

    //                 $cart_total += $item_total;


    //                 $res = Restock::create([
    //                     'summary_id' => $summary->id,
    //                     'product_id' => $item_id,
    //                     'net_weight' => $net_weight,
    //                     'gross_weight' => $gross_weight,
    //                     'bags' => $bags,
    //                     'price' => $price,
    //                     'moisture_discount' => $moisture_discount
    //                 ]);


    //                 Stock::create([
    //                     'product_id' => $item_id,
    //                     'warehouse_id' => 1,
    //                     'net_weight' => $net_weight,
    //                     'gross_weight' => $gross_weight,
    //                     'customer_id' => 0,
    //                     'supplier_id' => $supplier_id,
    //                     'summary_id' => $res->id,
    //                     'price' => $price,
    //                     'bags' => $bags,
    //                     'total' => $item_total,
    //                     'action' => 'import',
    //                     'user_id' => $c_user,
    //                 ]);
    //             }
    //         }

    //         $summary->update([
    //             'total' => $cart_total
    //         ]);
    //     }

    //     return 'done';
    // }






    
    function calculatePrice($gross_weight, $discount, $bags, $type=1)
    {
        if ($type == 2) {
            return ($gross_weight / 1027);
        } else {
            return $gross_weight - ($discount + ($bags * 1.5));
        }
    }


    function giveCapital()
    {

        return;
        
        $customers = Customer::pluck('id')->toArray();

        $faker = Faker::create();
        for ($j = 0; $j <= 100 ; $j++) {
            Capital::create([
                'user_id' => $faker->randomElement($customers),
                'type' => 'export',
                'added_by' => auth()->user()->id,
                'amount' => $faker->numberBetween(50000, 2000000),
            ]);
        }
        
    }


    
    function fakerExport()
    {
        // return;

        $customers = Customer::pluck('id')->toArray();
        $staffs = User::pluck('id')->toArray();
        $products = Products::pluck('id')->toArray();

        $faker = Faker::create();

        

        for ($j = 0; $j <= 140; $j++) {

            $c_user = $faker->randomElement($staffs);
            $items = [];
            $expenses = [];

            $ii_end = $faker->numberBetween(0, 6);

            for ($i = 0; $i <= $ii_end; $i++) {
                $product = $faker->randomElement($products);
                $discount = $faker->numberBetween(0, 20);
                $product = Products::find($product);
                $bags = $faker->randomDigit();
                $gross_weight = $faker->numberBetween(100, 1000);
                $net_weight =  $this->calculatePrice($gross_weight, $discount, $bags, $product->type);
                $items[] = [
                    'id' => $product->id,
                    'bags' => $bags,
                    'name' => 'Cocoa',
                    'price' => $product->price,
                    'gross_weight' => $net_weight * 1.2,
                    'net_weight' => $net_weight,
                    'moisture_discount' => $discount,
                    'final_weight' =>  $net_weight,
                    'type' => $product->type
                ];
            }


            for ($i = 0; $i <= $faker->numberBetween(0, 6); $i++) {
                $amount = $faker->numberBetween(100, 30000);
                $expenses[] = [
                    'title' => $faker->word,
                    'amount' => $amount,
                ];
            }

            $request = [
                'customer_id' => $faker->randomElement($customers),
                'expenses' => $expenses,
                'items' => $items,
                'advance' => 0,
                'action' => 'import'

            ];

            $request = json_encode($request);
            $request = json_decode($request);




            $customer_id = $request->customer_id;
            $summary = SalesSummary::create([
                'warehouse_id' => 1,
                'user_id' => $c_user,
                'customer_id' => $customer_id,
                'total' => 0,
                'amount_paid' => $request->advance ?? 0,
                'lorry_number' => $faker->word()
            ]);

            $cart_total = 0;

            $client = [
                'id' => $customer_id,
                'user_type' => 'normal'
            ];

            $this->addStockExpense($request->expenses, $summary->id, $client, $request->action);

            $total_net_weight = 0;

            // return $request->items;

            if (count($request->items) > 0) {
                foreach ($request->items as $item) {
                    $item = (array) $item;
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


                    Stock::create([
                        'product_id' => $item_id,
                        'warehouse_id' => 1,
                        'net_weight' => -$net_weight,
                        'gross_weight' => -$gross_weight,
                        'customer_id' => $customer_id,
                        'moisture_discount' => $moisture_discount,
                        'supplier_id' => 0,
                        'summary_id' => $res->id,
                        'price' => $price,
                        'bags' => -$bags,
                        'total' => $item_total,
                        'action' => 'export',
                        'user_id' => $c_user,
                        'current_balance' => customerCredit($customer_id),
                    ]);
                }
            }

            $summary->update([
                'total' => $cart_total,
        
                'amount_paid' => rand(0, $cart_total)
            ]);
        }

        return 'done';
    }




    function addStockExpense($expenses, $summary_id, $client, $action)
    {
        foreach ($expenses as $expense) {
            $expense = (array) $expense;
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
        return;
    }



    
    function productBags($product_id)
    {
        $total_bags = Cstock::where(['product_id' => $product_id])->sum('bag');
        return $total_bags;
    }

    function productWeight($product_id)
    {
        $total_bags = Cstock::where(['product_id' => $product_id])->sum('weight');
        return $total_bags;
    }
}
