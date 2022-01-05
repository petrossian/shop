@extends('layouts.app')
@section('content')
    <div class="container">
        @foreach ($planchets as $planchet)
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
                        @if(isset($planchet->images[0]))
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="/img/{{$planchet->images[0]->file}}" alt="First slide">
                        </div>
                        @endif
                        @foreach($planchet->images as $k => $image)
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
                <h5 class="card-title">{{ $planchet->title }}</h5>
                <p class="card-text">
                    {{ $planchet->body }}
                </p>
                <br>
                <a href="/show/{{ $planchet->id }}" class="text-info border border-primary p-5 mt-5 d-block w-100">
                    Quick View
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        @endforeach
    </div>
@endSection
