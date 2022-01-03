@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row d-flex justify-content-center mh-100">

        <div class="card col-6 m-3 mt-5" style="display: table;height:100px;">
            <!-- carousel -->
            <div id="carouselExampleIndicators" class="carousel slide p-5" data-ride="carousel" style="
                            position:relative;
                            width:100%;
                            top:0;
                            left:0;
                            z-index:9999;
                        ">
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
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <!-- endCarousel -->

        </div>
        <div class="col-4 mt-5 offset-1">
            <h5 class="card-title">{{ $product->title }}</h5>
            <p class="card-text">
                {{ $product->body }}
            </p>
            <hr>
            @dump($coupons)
            @if ($coupons->count() != 0)
                @foreach ($coupons as $coupon)
                    <div>
                        <b>Price</b> <del>${{$coupon->price}}</del><b class="bg-warning text-success p-1 rounded">${{(int)$coupon->price - (int)$coupon->percent_off*(int)$coupon->price/100}}</b>
                    </div>
                    <div>
                        <b>Currency</b> {{$coupon->currency}}
                    </div>
                    <div class="text-right">
                        <b>Percent Off </b>-{{$coupon->percent_off}} %
                    </div>
                    <div class="text-right">
                        <b>Duration </b> <span class="text-success" style="font-weight:bolder;">{{$coupon->duration}}</span>
                    </div>
                @endforeach
            @else
                @foreach ($all_coupons as $coupon)
                @dump($coupon->id)
                    <h4 class="text-center text-success d-flex justify-content-around">
                        Get Coupon BY
                        ${{$product->price*($coupon->percent_off/2)/100}}
                        <form action="/get-coupon/{{ $coupon->id }}/{{ $product->id }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" style="background-color:white;color:green;">+</button>
                        </form>
                    </h4>
                    <div>
                        <b>Price</b> <del>${{$product->price}}</del>  <b class="bg-warning text-success p-1 rounded">${{$product->price - $product->price*$coupon->percent_off/100}}</b>
                    </div>
                    <div>
                        <b>Currency</b> {{$coupon->currency}}
                    </div>
                    <div class="text-right">
                        <b>Percent Off </b>-{{$coupon->percent_off}} %
                    </div>
                    <div class="text-right">
                        <b>Duration </b> <span class="text-success" style="font-weight:bolder;">{{$coupon->duration}}</span>
                    </div>
                @endforeach
            @endif
            <br><br>
            <footer class="card-footer d-flex justify-content-around">
                <div>
                    @if($isLiked == false)
                    <form action="/like/{{$product->id}}" method="post">
                        @csrf
                        <button type="submit" style="border:none;">+<i class="fa fa-heart-o"></i></button>

                    </form>
                    @else
                    <form action="/unlike/{{$product->id}}" method="post">
                        @csrf
                        <button type="submit" style="border:none;">-<i class="fa fa-heart-o"></i></button>
                        <sub class="text-danger"><b>{{$count}}</b></sub>
                    </form>
                    @endif
                </div>
                <a href="/stripe/{{ $product->id }}">
                    <i class="fa fa-shopping-cart"></i></i>
                    {{ $charts_count }}
                </a>
            </footer>
        </div>
    </div>
@endSection
