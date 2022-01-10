@extends('layouts.app')
@section('content')
<div id="tab2" class="tab-pane fade in active">
    <div class="products-slick" data-nav="#slick-nav-2">
        @foreach ($products as $product)

            <!-- product -->
            <div class="product">
                <div class="product-img">
                    <img src="./img/{{ $product->images[0]->file }}" alt="">
                    <div class="product-label">
                        <span class="sale">-30%</span>
                        <span class="new">NEW</span>
                    </div>
                </div>
                <div class="product-body">
                    <p class="product-category">
                        @foreach ($product->categories as $category)
                            <span>{{ $category->category }}</span>
                        @endforeach
                    </p>
                    <h3 class="product-name"><a href="#">{{ $product->title }}</a></h3>
                    <h4 class="product-price">${{ $product->price }}</h4>
                    <div class="product-btns d-flex justify-content-around">
                        @if(!\App\HTTP\Controllers\HomeController::isLiked($product->id))
                            <form action="/like/{{$product->id}}" method="post">
                                @csrf
                                <button type="submit" style="border:none;">+<i class="fa fa-heart-o"></i></button>
                                <sub class="text-danger"><b>{{ \App\HTTP\Controllers\HomeController::likeCount($product) }}</b></sub>
                            </form>
                        @else
                            <form action="/unlike/{{$product->id}}" method="post">
                                @csrf
                                <button type="submit" style="border:none;">-<i class="fa fa-heart-o"></i></button>
                                <sub class="text-danger"><b>{{ \App\HTTP\Controllers\HomeController::likeCount($product) }}</b></sub>
                            </form>
                        @endif
                        <a href="/stripe/{{ $product->id }}" class="add-to-chart">
                            <i class="fa fa-shopping-cart"></i></i>
                            <sub>{{ $product->sail_count }}</sub>
                        </a>
                        <a href="/show/{{ $product->id }}" class="quick-view"><i class="fa fa-eye"></i></a>
                    </div>
                </div>
            </div>
            <!-- /product -->
        @endforeach

    </div>
    <div id="slick-nav-2" class="products-slick-nav"></div>
</div>
@endsection
