<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    function productsIndex(Request $request)
    {
        if ($request->search) {
            $products = Products::where('name', 'like', "%$request->search%")->paginate(25);
        } else {
            $products = Products::orderby('id', 'desc')->paginate(25);
        }


        foreach($products as $product) {
            $product->stock_weight = $this->productWeight($product->id);
            $product->stock_bag = $this->productBags($product->id);
        }

        return view('control.add_product', compact(['products']));
    }


    function createProduct(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|unique:products,name',
            'description' => 'string',
            'price' => 'required|integer', 
        ])->validate();

        Products::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => (int)$request->price,
            'cost_price' => (int)$request->price,

        ]);

        return back()->with('success', 'Product has been created scuessfuly');
    }


    function deleteProduct($id)
    {
        // Products::where('id', $id)->delete();

        return back()->with('success', 'product has been deleted');
    }


    
}
