@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            @foreach($laptops as $laptop)
                <div class="card col-3 m-3">
                    <!-- carousel -->
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="
                                    position:relative;
                                    width:100%;
                                    top:0;
                                    left:0;
                                    z-index:9999;
                                ">
                                    <div class="carousel-inner">
                                        @if(isset($laptop->images[0]))
                                        <div class="carousel-item active">
                                            <img class="d-block w-100" src="/img/{{$laptop->images[0]->file}}" alt="First slide">
                                        </div>
                                        @endif
                                        @foreach($laptop->images as $k => $image)
                                            @if($k != 0)
                                            <div class="carousel-item">
                                                <img class="d-block w-100" src="/img/{{$image->file}}" alt="Second slide">
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                                <!-- endCarousel -->
                    <div class="card-body">
                        <h5 class="card-title">{{ $laptop->title }}</h5>
                        <p class="card-text">
                            {{ $laptop->body }}
                        </p>
                        <a href="/show/{{$laptop->id}}" class="btn btn-primary">
                            <i class="fa fa-eye"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endSection