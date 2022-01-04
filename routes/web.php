<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\LikeController;
// use App\Http\Controllers\LikeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\WishlistsController;
use App\Models\Category;
use Facade\FlareClient\View;
use Facade\Ignition\Exceptions\ViewException;
use Illuminate\Contracts\View\View as ViewView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\ViewException as ViewViewException;
use App\Http\Controllers\SubscribetionController;
use App\Models\Product;
use Doctrine\Inflector\Rules\Substitution;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/admin/home', [AdminController::class, 'home']);
Route::get('/admin/products-table', [AdminController::class, 'productsTable']);
Route::get('/admin/users-table', [AdminController::class, 'usersTable']);
Route::get('/admin/delete-user/{id}', [AdminController::class, 'deleteUser']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/show/{id}', [App\Http\Controllers\HomeController::class, 'show']);
Route::post('/search', [SearchController::class, 'search']);

Route::get('/categories', [CategoriesController::class, 'index']);
Route::get('/categories/laptops', [CategoriesController::class, 'laptops']);
Route::get('/categories/phones', [CategoriesController::class, 'phones']);
Route::get('/categories/cameras', [CategoriesController::class, 'cameras']);
Route::get('/wishlist', [WishlistsController::class, 'index']);

Route::post('/like/{id}', [App\Http\Controllers\LikeController::class, 'index']);
Route::post('/unlike/{id}', [App\Http\Controllers\LikeController::class, 'unlike']);

Route::get('/chart', [ChartController::class, 'chart']);
Route::post('/add-to-chart/{id}', [ChartController::class, 'addToChart']);

Route::resource('/admin/products', ProductController::class);
Route::get('/admin/charts', function (){
    return view('admin.charts');
});

Route::get('stripe/{product_id}', [StripeController::class, 'stripe']);
// Route::post('stripe/{product_id}', [StripeController::class, 'stripePost'])->name('stripe.post');
Route::post('checkout/{product_id}', [StripeController::class, 'checkout']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/subscribetion/{id}', [SubscribetionController::class, 'subscribetion']);
Route::post('/subscribe/{id}', [SubscribetionController::class, 'subscribe']);

Route::post('/get-coupon/{coupon_id}/{product_id}', [CouponController::class, 'getCoupon']);

Route::get('/user-coupon/{coupon_id}/{stripe_id}/{product_id}', function($coupon_id, $stripe_id, $product_id){
    $product = Product::find($product_id);
    $prod_id = $product->stripe_id;

    $coupon = DB::table('coupon_user')
        ->join('coupons', 'coupons.coupon_id', 'coupon_user.coupon_id')
        ->where('coupon_user.customer_id', $stripe_id)
        ->where('coupons.coupon_id', $coupon_id)
        ->where('coupons.applies_to', $prod_id)
        ->first();

    return response()->json($coupon);
});
