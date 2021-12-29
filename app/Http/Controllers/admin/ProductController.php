<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->simplePaginate(5);
        return view('admin.products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new Product();

        $validated = $request->validate([
            'category_id' => 'required',
            'title' => 'required|max:255',
            'body' => 'required',
            'file' => 'required',
            'price' => 'required',
        ]);

        $stripe = new \Stripe\StripeClient(
            'sk_test_51K6E5LE36R3nQNklMcOvFOc6gfpSpjsBOdbWaBQaz2ckZzjbjlkWLM4MXZEZ1fk6eoIlSh5B3XF2s6Hpe40ku8lu00Q3vVPvh4'
        );

        $model->category_id = $request->input('category_id');
        $model->title = $request->input('title');
        $model->body = $request->input('body');
        $model->file = $request->input('file');
        $price = $request->input('price');

        $stripe_id = $stripe->products->create([
            'name' => $model->title,
            'description' => $model->body
        ])->id;

        $product_id = DB::table('products')->insertGetId([
            'title'=>$request->input('title'),
            'body'=>$request->input('body'),
            'price'=>$request->input('price'),
            'stripe_id'=>$stripe_id
        ]);
        foreach($request->file as $file){
            if($file->move(public_path('\img'), $file->getClientOriginalName())){

                if($product_id){
                    $image_id = DB::table('images')->insertGetId([
                        'file'=>$file->getClientOriginalName()
                    ]);

                }
                if($image_id){
                    DB::table('image_product')->insert([
                        'product_id'=>$product_id,
                        'image_id'=>$image_id
                    ]);
                }
            }
        }

        DB::table('category_product')->insert([
            'category_id'=>$request->input('category_id'),
            'product_id' => $product_id
        ]);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return view('admin.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('admin.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = DB::table('products')->where('id', $id)->update([
            'title'=>$request->input('title'),
            'body'=>$request->input('body'),
            'price'=>$request->input('price')
        ]);
        $update = DB::table('category_product')->where('product_id', $id)->update([
            'category_id'=>$request->input('category_id'),
        ]);
        return redirect("/admin/products/$id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $del = DB::table('products')->where('id', $id)->delete();

        if($del){
            return back();
        }
    }
}
