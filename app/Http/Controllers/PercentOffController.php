<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PercentOffController extends Controller
{
    public function index(){
        $c_products = DB::table('products')
        ->join('coupon_product', 'products.stripe_id', 'coupon_product.product_id')
        ->get();
        $products = Product::all();
        $p = [];
        foreach($products as $product){
            foreach($c_products as $c_product){
                if($product->id == $c_product->id){
                    $p[] = $product;
                }
            }
        }
        $products = $p;
        return view('percent_off', compact('products'));
    }
}
