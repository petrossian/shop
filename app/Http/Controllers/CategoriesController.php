<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index(){

    }

    public function laptops(){
        $laptops = [];
        $products = Product::all();
        foreach($products as $product){
            foreach($product->categories as $category){
                if($category->id == 1){
                    $laptops[] = $product;
                }
            }
        }
        return view('laptops', compact('laptops'));
    }
    public function phones(){
        $phones = [];
        $products = Product::all();
        foreach($products as $product){
            foreach($product->categories as $category){
                if($category->id == 2){
                    $phones[] = $product;
                }
            }
        }
        return view('phones', compact('phones'));
    }
    public function planchets(){
        $planchets = [];
        $products = Product::all();
        foreach($products as $product){
            foreach($product->categories as $category){
                if($category->id == 3){
                    $planchets[] = $product;
                }
            }
        }
       return view('planchets', compact('planchets'));
    }
}
