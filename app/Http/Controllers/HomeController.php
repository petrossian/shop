<?php

namespace App\Http\Controllers;

use App\Models\Chart;
use App\Models\Coupon;
use App\Models\Like;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public static $user_id;
    public static $product_id;
    public static $isLiked;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('home');
    }
    public function show($id){
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $customer_id = $user->stripe_id;
        $product = Product::find($id);
        $product_id = $product->id;
        if(Chart::where('product_id', $id)->first() == null){
            $charts_count = 0;
        }else{
            $charts_count = Chart::where('product_id', $id)->first()->count;
        }
        $coupons = DB::table('coupon_user')
            ->join('coupons', 'coupons.coupon_id', 'coupon_user.coupon_id')
            ->join('products', 'coupons.applies_to', 'products.stripe_id')
            ->where('coupon_user.customer_id', $customer_id)
            ->where('products.id', $product_id)
            ->get();
        $all_coupons = DB::table('coupons')
            ->get();

        $count = Wishlist::where('product_id', $id)->get()->count();

        $wishlist = $product->wishlists->where('user_id', $user_id)->first();
        $isLiked = false;
        if($wishlist != null){
            $isLiked = true;
        }
        return view('show', compact('product', 'count', 'isLiked', 'coupons', 'charts_count', 'all_coupons'));
    }
}
