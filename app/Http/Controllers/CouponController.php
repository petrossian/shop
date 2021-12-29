<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Stripe\Balance;

use function GuzzleHttp\Promise\inspect;

class CouponController extends Controller
{
    public function getCoupon($coupon_id, $product_id){
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $customer_id = $user->stripe_id;
        $coupon = Coupon::find($coupon_id);
        $product = Product::find($product_id);
        $coupon_price = $product->price;
        $coupon_id = $coupon->coupon_id;
        $balance = (int)str_replace(',', '', ltrim($user->balance(), '$'));
        if($balance >= $coupon_price){
            $ammount_off = $coupon_price-($coupon_price*$coupon->percent_off/100);
            $user->applyBalance((1-$ammount_off)*100, 'Premium customer top-up.');
            $row = DB::table('coupon_user')->insert(
                [
                    'customer_id' => $customer_id,
                    'coupon_id' => $coupon_id
                ]
            );
            if($row){
                Session::flash('success', 'apeeeeeeeee!!!!, you get coupon successfully!');
                return back();
            }
        }else{
            echo "Balanc@ heriq chi an@m";
        }
    }
}
