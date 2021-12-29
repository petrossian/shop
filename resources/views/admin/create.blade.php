@extends('admin.layouts.app')
@section('content')
    <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    Create A New Product
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body">
                    <div class="col-8 offset-2">
                        <form action="/admin/products" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <h4 class="text-secondary"></h4>
                            <div class="input-group">
                                <label>Post Category Id</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" name="category_id" placeholder="Post Category Id" class="form-control ml-5">
                            </div>
                            <div class="input-group mt-3">
                                <label>Post Title</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" name="title" placeholder="Post Title" class="form-control ml-5">
                            </div>
                            <div class="input-group mt-3">
                                <label>Post Body</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <textarea type="text" name="body" class="form-control ml-5">Post Body</textarea>
                            </div>
                            <div class="input-group mt-3">
                                <label>Product Image</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="file" name="file[]" multiple="multiple" placeholder="Post Title" class="form-control ml-5">
                            </div>
                            <div class="input-group mt-3">
                                <label>Product Image</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" name="price" placeholder="Product Price" class="form-control ml-5">
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