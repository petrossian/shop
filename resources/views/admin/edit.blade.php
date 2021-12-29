@extends('admin.layouts.app')
@section('content')
<div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    Edit This Product
                </div>
                <div class="card-body">
                    <div class="col-8 offset-2">
                        <form action="/admin/products/{{$product->id}}" method="POST">
                            @csrf
                            @method('PUT')
                            <h4 class="text-secondary"></h4>
                            <div class="input-group">
                                <label>Post Category Id</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                @foreach($product->categories as $category)
                                    <input value="{{$category->id}}" type="text" name="category_id" placeholder="Post Category Id" class="form-control ml-5">
                                @endforeach
                            </div>
                            <div class="input-group mt-3">
                                <label>Post Title</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input value="{{$product->title}}" type="text" name="title" placeholder="Post Title" class="form-control ml-5">
                            </div>
                            <div class="input-group mt-3">
                                <label>Post Body</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <textarea type="text" name="body" class="form-control ml-5">{{$product->body}}</textarea>
                            </div>
                            <!-- <div class="input-group mt-3">
                                <label>Product Image</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input value="{{$product->file}}" type="file" name="file" placeholder="Post Title" class="form-control ml-5">
                            </div> -->
                            <img src="/img/{{$product->file}}" alt="Current Image" title="Current Image" class="mt-3">
                            <div class="input-group mt-3">
                                <label>Product Image</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input value="{{$product->price}}" type="text" name="price" placeholder="Product Price" class="form-control ml-5">
                            </div>
                            <hr>
                            <div class="input-group mt-3 d-flex justify-content-end">
                                <button class="btn btn-sm btn-success d-block float-right">Go</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
    </div>
@endSection