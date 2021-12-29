
@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mt-3">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Products Data
                    </div>
                    <div class="card-body">
                        <div id="products_table">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Body</th>
                                        <th>Price</th>
                                        <th>File</th>
                                        <th>Category</th>
                                        <th class="text-info">Tools</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Body</th>
                                        <th>Price</th>
                                        <th>File</th>
                                        <th>Category</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{$product->id}}</td>
                                            <td>{{$product->title}}</td>
                                            <td>{{$product->body}}</td>
                                            <td>{{$product->price}}</td>
                                            <td>{{$product->file}}</td>
                                            <td>
                                                @foreach($product->categories as $category)
                                                    <span>{{ $category->category }}</span>
                                                @endforeach
                                            </td>
                                            
                                            <td>
                                                <a href="/admin/products/{{$product->id}}">
                                                    <i class="fa fa-tools"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{$products->links()}}
                </div>
            </div>
        </div>
    </div>
@endSection