<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

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
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $customer_id = $user->stripe_id;
        $product = Product::find($id);
        $price_id = $request->input('price_id');
        $stripe = new \Stripe\StripeClient(
            'sk_test_51K6E5LE36R3nQNklMcOvFOc6gfpSpjsBOdbWaBQaz2ckZzjbjlkWLM4MXZEZ1fk6eoIlSh5B3XF2s6Hpe40ku8lu00Q3vVPvh4'
        );

        $validated = $request->validate([
            'price_id' => 'required',
        ]);
        // $user->applyBalance(-11*100, 'Premium customer top-up.');
        $stripe->subscriptions->create([
            'customer' => $customer_id,
            'items' => [
              ['price' => $price_id],
            ],
          ]);
        Session::flash('success', 'apeeeeeeeee!!!!, Payment successful!');
        return back();
    }


}
