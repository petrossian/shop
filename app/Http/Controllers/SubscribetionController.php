<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use \Stripe\Plan;


class SubscribetionController extends Controller
{
    public function subscribetion($id){
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        // $user->applyBalance(11000*100, 'Premium customer top-up.');
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
        $user = $request->user();
        \Stripe\Stripe::setApiKey('sk_test_51K6E5LE36R3nQNklMcOvFOc6gfpSpjsBOdbWaBQaz2ckZzjbjlkWLM4MXZEZ1fk6eoIlSh5B3XF2s6Hpe40ku8lu00Q3vVPvh4');
        $paymentMethod = \Stripe\PaymentMethod::all([
            'customer' =>  $user->stripe_id,
            'type' => 'card',
        ]);
        // dd($paymentMethod);
        $price_id = $request->input('price_id');
        $user->newSubscription('default', $price_id)
        ->create($paymentMethod->data[0]->id,[
            'email' => $user->email,
            'amount' => 2000
        ]);

        Session::flash('success', 'apeeeeeeeee!!!!, Subscription created successfuly!');
        return back();
    }

}
