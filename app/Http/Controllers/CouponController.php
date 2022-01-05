<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Money\Currency;
use Session;
use Stripe\Balance;

use function GuzzleHttp\Promise\inspect;

class CouponController extends Controller
{
    public function index(){
        return view('admin.coupon');
    }
    public function createCoupon(Request $request){
        $stripe = new \Stripe\StripeClient(
            'sk_test_51K6E5LE36R3nQNklMcOvFOc6gfpSpjsBOdbWaBQaz2ckZzjbjlkWLM4MXZEZ1fk6eoIlSh5B3XF2s6Hpe40ku8lu00Q3vVPvh4'
        );
        $coupon = $stripe->coupons->create([
            'name' => $request->name,
            'currency' => $request->currency,
            'percent_off' => $request->percent_off,
            'duration' => $request->duration,
            'duration_in_months' => 3,
        ]);
        DB::table('coupons')->insert([
            'coupon_id' => $coupon->id,
            'currency' => $request->currency,
            'percent_off' => $request->percent_off,
            'duration' => $request->duration,
            'applies_to' => $request->applies_to
        ]);
        return back();
    }
    public function applyCoupon(Request $request){
        $customer_id = $request->customer_id;
        $coupon_id = $request->coupon_id;
        DB::table('coupon_user')->insert([
            'customer_id' => $customer_id,
            'coupon_id' => $coupon_id,
        ]);
        return back();
    }
}
