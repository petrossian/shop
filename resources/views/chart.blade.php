@extends('layouts.app')
@section('content')
<div class="container">
        <div class="row d-flex justify-content-center">
            @foreach($charts as $key => $chart)
            <div class="card m-5" id="{{$key}}">
                <figure>
                    <div id="{{$key}}" class="carousel slide" data-ride="carousel" style="
                        position:relative;
                        width:100%;
                        top:0;
                        left:0;
                        z-index:9999;
                    ">
                        <div class="carousel-inner">
                            @if(isset($chart->product->images))
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="/img/{{ $chart->product->images[0]->file }}" alt="First slide">
                                </div>
                                @foreach($chart->product->images as $k => $image)
                                    @if($k != 0 AND count($chart->product->images)>1)
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="/img/{{$image->file}}" alt="Second slide">
                                    </div>
                                    @endif
                                @endforeach
                            @endif
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
                </figure>
                <section class="details">
                  <div class="min-details">
                    <h1>{{ $chart->product->title }}</h1>
                    <h1 class="price">${{ $chart->product->price }}</h1>
                  </div>

                  <div class="options">
                    {{ $chart->product->body }}
                </div>
                <div class="d-flex justify-content-around p-3">
                    @if(App\Http\Controllers\StripeController::isLiked($chart->product->id) == false)
                        <form action="/like/{{ $chart->product->id }}" method="post">
                            @csrf
                            <button type="submit" style="border:none;"><a href="#">+<i class="fa fa-heart-o"></i></button>
                            <sub>{{ App\Http\Controllers\StripeController::count($chart->product->id) }}</sub>
                        </form>
                        @else
                        <form action="/unlike/{{ $chart->product->id }}" method="post">
                            @csrf
                            <button type="submit" style="border:none;background-color:white;"><a href="#">-<i class="fa fa-heart-o"></i></a></button>
                            <sub class="text-danger"><b>{{ App\Http\Controllers\StripeController::count($chart->product->id) }}</b></sub>
                        </form>
                    @endif
                    <a href="/stripe/{{ $chart->product->id }}">
                        <i class="fa fa-shopping-cart"></i></i>
                        {{ App\HTTP\Controllers\ChartController::chart_count($chart->product->id) }}
                    </a>
                </div>
                <a href="/stripe/{{ $chart->product->id }}" class="btn">
                    <i class="fa fa-shopping-cart"></i></i>
                    add to cart
                </a>
              </section>
            </div>
            @endforeach
        </div>
    </div>
@endSection
