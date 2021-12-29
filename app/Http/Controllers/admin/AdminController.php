<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(AdminMiddleware::class);
    }
    public function index(){
        return 1;
    }
    public function home(){
        $name = Auth::user('name');
        return view('admin.home', compact('name'));
    }
    
    public function productsTable(){
        $products = Product::simplePaginate(5);
        return view('admin.products-table', compact('products'));
    }

    public function usersTable(){
        $users = User::simplePaginate(5);
        return view('admin.users-table', compact('users'));
    }

    public function deleteUser($id){
        $delete = DB::table('users')->where('id', $id)->delete();
        if($delete){
            return back();
        }
    }

}
