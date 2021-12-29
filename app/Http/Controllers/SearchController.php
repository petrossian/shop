<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request){
        $search_category = $request->input('search_category');
        $search_text = $request->input('search_text');
        if($search_category != "null"){
            $results = Category::where('category','=', $search_category)->first();
            $id = $results->id;
            $results = [];
            $products = Product::all();
            foreach($products as $product){
                foreach($product->categories as $category){
                    if($category->id == $id){
                        $results[] = $product;
                    }
                }
            }
            
            return view('search', compact('results'));
        }elseif($search_text != null AND !empty($search_text)){
            $results = Product::where('title', 'LIKE', "%$search_text%")->get();
            return view('search', compact('results'));
        }else{
            return view('no-result');
        }
    }
}
