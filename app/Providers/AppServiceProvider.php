<?php

namespace App\Providers;

use App\Http\Controllers\LikeController;
use App\Models\Category;
use App\Models\Chart;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public static $isAdmin = false;
    public static $user;
    public function boot()
    {
        Cashier::useCustomerModel(User::class);
        Cashier::useSubscriptionModel(Subscription::class);

        view()->composer('*', function ($view) {
            if(Auth::check()){
                $user_id = Auth::user()->id;
                self::$user = User::find($user_id);
                $view->with('categories', Category::all());
                $balance = self::$user->balance();
                $balance = ltrim($balance, '-');
                $view->with('balance', $balance);
            }else{
                $view->with('categories', Category::all());
            }
        });
        view()->composer('layouts.app', function ($view) {
            if(Auth::check()){
                $user_id = Auth::user()->id;
                $admin = User::find($user_id);
                foreach($admin->roles as $role){
                    if($role->name == 'admin'){
                        self::$isAdmin = true;
                    }
                }
                $wishlists = Wishlist::where('user_id', $user_id)->count();
                $charts = Chart::where('user_id', $user_id)->count();

                $view->with('isAdmin', self::$isAdmin);
                $view->with('wishlists', $wishlists);
                $view->with('charts', $charts);
            }else{
                $view->with('isAdmin', false);


            }
        });


    }
}
