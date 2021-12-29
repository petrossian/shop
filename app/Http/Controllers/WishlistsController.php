<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistsController extends Controller
{
    public function index(){
        $user_id = Auth::user()->id;
        $wishlists = [];
        $products = Product::all();
        foreach($products as $k=> $product){
            foreach($product->wishlists as $wishlist){
                if($wishlist->user_id == $user_id){
                    $wishlists[] = $product;
                }
            }
        }

        return view('wishlist', compact('wishlists'));
    }
}
