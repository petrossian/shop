<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Chart;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Product;
use App\Models\Wishlist;

use Laravel\Cashier\Cashier;

class StripeController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

    public static function count($product_id){
        return Wishlist::where('product_id', $product_id)->get()->count();
    }

    public function stripe(Request $request, $id)
    {
        $status = null;
        if(session()->has('status')){
            $status = session('status');
        }
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $product = Product::find($id);
        $price = $product->price;
        $customer_id = $user->stripe_id;
        $coupons = DB::table('coupon_user')
            ->join('coupons', 'coupons.coupon_id', 'coupon_user.coupon_id')
            ->where('coupon_user.customer_id', $customer_id)
            ->get();
        return view('stripe', compact('id', 'status', 'coupons', 'price'));
    }

    public static function isLiked($product_id){
        $user_id = Auth::user()->id;
        $product = Product::find($product_id);

        $wishlist = $product->wishlists->where('user_id', $user_id)->first();
        $isLiked = false;
        if($wishlist != null){
            $isLiked = true;
        }
        return $isLiked;
    }

    public function checkout(Request $request, $id){
        if($request->coupon_id != null){
            $coupon = Coupon::where('coupon_id', $request->coupon_id)->first();
            $percent_off = $coupon->percent_off;
        }else{
            $percent_off = 0;
        }

        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        // $user->applyBalance(-700000*100, 'Premium customer top-up.');

        $phone = $user->phone->phone;

        $product = Product::find($id);

        $price = $product->price;
        $stripeId = $user->stripe_id;

        $product_id = $id;

        $chart = Chart::where('user_id', $user_id)->where('product_id', $product_id)->first();

        $coupons = DB::table('coupon_user')
            ->join('coupons', 'coupons.coupon_id', 'coupon_user.coupon_id')
            ->where('coupon_user.customer_id', $stripeId)
            ->first();
        $coupon_price = $product->price;
        // $balance = (int)str_replace(',', '', ltrim($user->balance(), '-$'));

        // if($balance >= $coupon_price){

            // $user->applyBalance(($price)*100, 'Premium customer top-up.');
            if($chart == null){
                $sql = DB::table('charts')->insert([
                    'user_id' => $user_id,
                    'product_id' => $product_id

                ]);
                Stripe::setApiKey(env('STRIPE_SECRET'));
                $stripe = new \Stripe\StripeClient(
                    'sk_test_51K6E5LE36R3nQNklMcOvFOc6gfpSpjsBOdbWaBQaz2ckZzjbjlkWLM4MXZEZ1fk6eoIlSh5B3XF2s6Hpe40ku8lu00Q3vVPvh4'
                );
                $stripe->customers->createSource(
                    $stripeId,
                    ['source' => $request->stripeToken]
                );
                Charge::create ([
                    "amount" => ($price-$price*$percent_off/100)*100,
                    "currency" => "usd",
                    "customer" => $stripeId,
                    "description" => "This payment is tested purpose phpcodingstuff.com",
                ]);
                if($sql){
                    Session::flash('success', 'Payment successful!');
                    return back();
                }
            }else{
                DB::table('charts')->where('user_id', $user_id)->where('product_id', $product_id)->update([
                    'count' => $chart->count+1
                ]);
                Stripe::setApiKey(env('STRIPE_SECRET'));
                $stripe = new \Stripe\StripeClient(
                    'sk_test_51K6E5LE36R3nQNklMcOvFOc6gfpSpjsBOdbWaBQaz2ckZzjbjlkWLM4MXZEZ1fk6eoIlSh5B3XF2s6Hpe40ku8lu00Q3vVPvh4'
                );
                $src = $stripe->customers->createSource(
                    $stripeId,
                    ['source' => $request->stripeToken]
                );
                Charge::create ([
                    "amount" => ($price-$price*$percent_off/100)*100,
                    "currency" => "usd",
                    "customer" => $stripeId,
                    "description" => "This payment is tested purpose phpcodingstuff.com",
                ]);
                Session::flash('success', 'Payment successful!');
                return back();
            }
        // }else{
            // die("Your balance <= 0");
        // }
    }
}
