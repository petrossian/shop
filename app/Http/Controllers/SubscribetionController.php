<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use \Stripe\Plan;
use \Stripe\Charge;


class SubscribetionController extends Controller
{
    public function subscribetion($id){
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $product = Product::find($id);
        $productId = $product->stripe_id;
        $p = [];
        $stripe = new \Stripe\StripeClient(
            'sk_test_51K6E5LE36R3nQNklMcOvFOc6gfpSpjsBOdbWaBQaz2ckZzjbjlkWLM4MXZEZ1fk6eoIlSh5B3XF2s6Hpe40ku8lu00Q3vVPvh4'
        );
        $prices = $stripe->prices->all();
        foreach($prices->data as $price){
            if($price->product == $productId && $price->recurring != '' || isset($price->recurring)){
                $p[] = $price;
            }
        }
        $prices = $p;
        return view('subscribetion', compact('id', 'prices'));
    }

    public function subscribe(Request $request, $id){
        \Stripe\Stripe::setApiKey("sk_test_51K6E5LE36R3nQNklMcOvFOc6gfpSpjsBOdbWaBQaz2ckZzjbjlkWLM4MXZEZ1fk6eoIlSh5B3XF2s6Hpe40ku8lu00Q3vVPvh4");
        $stripe = new \Stripe\StripeClient(
            'sk_test_51K6E5LE36R3nQNklMcOvFOc6gfpSpjsBOdbWaBQaz2ckZzjbjlkWLM4MXZEZ1fk6eoIlSh5B3XF2s6Hpe40ku8lu00Q3vVPvh4'
        );
        $price = $stripe->prices->retrieve(
            $request->price_id,
            []
        );
        //
        $stripe->subscriptions->create([
            'customer' => $request->user()->stripe_id,
            'items' => [
                ['price' => $request->price_id],
            ],
        ]);

        Session::flash('success', 'apeeeeeeeee!!!!, Subscription created successfuly!');
        return back();
    }

}
