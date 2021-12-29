<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    public static $user_id;
    public static $product_id;
    public static $isLiked;
    public function index(Request $request, $id){
        $user_id = Auth::user()->id;
        $product_id = $id;
        self::$isLiked = DB::table('wishlists')->where('user_id', $user_id)->where('product_id', $product_id)->get();
        if(count(self::$isLiked) < 1){
            $sql = DB::table('wishlists')->insert([
                'user_id' => $user_id,
                'product_id' => $product_id
            ]);

            if($sql){
                return back();
            }
        }else{
            return back();
        }
    }

    public function unlike(Request $request, $id){
        $user_id = Auth::user()->id;
        $product_id = $id;
        self::$isLiked = DB::table('wishlists')->where('user_id', $user_id)->where('product_id', $product_id)->get();
        // dd(self::$isLiked);
        if(count(self::$isLiked) == 1){
            $sql = DB::table('wishlists')->where('user_id', $user_id)->where('product_id', $product_id)->delete();
            if($sql){
                return back();
            }
        }else{
            return back();
        }
    }

}
