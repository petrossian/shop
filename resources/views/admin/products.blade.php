@extends('admin.layouts.app')
@section('content')
<div class="container pt-5">
    <div class="row">
        <div class="col-12">
            <h3>All Products</h3>
            @foreach($products as $key => $product)
                <div class="card mt-3">
                    <div class="card-header">
                        Featured
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div style="
                                    display:block;
                                    width:100%;
                                ">
                                <!-- carousel -->
                                <div id="{{$key}}" class="carousel slide" data-ride="carousel" style="
                                    position:relative;
                                    width:100%;
                                    top:0;
                                    left:0;
                                ">
                                    <ol class="carousel-indicators">
                                        <li data-target="#{{$key}}" data-slide-to="0" class="active"></li>
                                        <li data-target="#{{$key}}" data-slide-to="1"></li>
                                        <li data-target="#{{$key}}" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        @if(isset($product->images[0]))
                                        <div class="carousel-item active">
                                            <img class="d-block w-100" src="/img/{{$product->images[0]->file}}" alt="First slide">
                                        </div>
                                        @endif
                                        @foreach($product->images as $k => $image)
                                            @if($k != 0)
                                            <div class="carousel-item">
                                                <img class="d-block w-100" src="/img/{{$image->file}}" alt="Second slide">
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <a class="carousel-control-prev" href="#{{$key}}" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#{{$key}}" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                                <!-- endCarousel -->
                                </div>
                            </div>
                            <div class="col-8">
                                @foreach($product->categories as $category)
                                    <span class="p-2 text-success">
                                        Categories`  {{$category->category}}
                                    </span>,
                                @endforeach
                                <h5 class="card-title">{{$product->title}}</h5>
                                <p class="card-text">
                                    {{$product->body}}
                                </p>
                                <a href="/admin/products/{{$product->id}}" class="btn btn-primary">View Product</a>
                                <form action="/admin/products/{{$product->id}}?page={{$products->links()->paginator->currentPage()}}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"class="btn btn-danger">
                                        <i class="fa fa-trash"></i>Delete Product
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
      
</div>
<div class="mt-5 col-12 mb-3">
    {{ $products->links() }}
    <style>
        nav[role="navigation"]{
            display: flex;
            justify-content: center;
        }
    </style>
</div> 
@endSection