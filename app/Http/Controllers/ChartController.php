<?php

namespace App\Http\Controllers;

use App\Models\Chart;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{

    public static $received;

    public static function chart_count($product_id){
        $user_id = Auth::user()->id;
        $charts = Chart::where('product_id', $product_id)->get();
        $count = 0;
        foreach($charts as $chart){
            $count+=$chart->count;
        }
        return $count;
    }

    public function chart(){
        $user_id = Auth::user()->id;
        $charts = [];
        $ch = Chart::all();
        foreach($ch as $k=> $chart){
            if($chart->user_id == $user_id){
                $charts[] = $chart;
            }
        }
        dd($charts);
        return view('chart', compact('charts'));
    }

    public function addToChart($id){
        $user_id = Auth::user()->id;
        $product_id = $id;
        self::$received = DB::table('charts')->where('user_id', $user_id)->where('product_id', $product_id)->get();
        $sql = DB::table('charts')->insert([
            'user_id' => $user_id,
            'product_id' => $product_id
        ]);
        if($sql){
            session(['status' => 'Task was successful!']);
            return back();
        }
    }


}
