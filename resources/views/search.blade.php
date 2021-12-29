@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            @foreach($results as $key => $result)
            <div class="card col-6 m-3">
            <!-- carousel -->
            <div id="{{$key}}" class="carousel slide" data-ride="carousel" style="
                            position:relative;
                            width:100%;
                            top:0;
                            left:0;
                            z-index:9999;
                        ">
                 <div class="carousel-inner">
                    @if(isset($result->images[0]))
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="/img/{{$result->images[0]->file}}" alt="First slide">
                    </div>
                    @endif
                    @foreach($result->images as $k => $image)
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
            <div class="card-body">
                <h5 class="card-title">{{ $result->title }}</h5>
                <p class="card-text">
                    {{ $result->body }}
                </p>
            </div>
            <a href="/show/{{$result->id}}" class="btn btn-primary">
                <i class="fa fa-eye"></i>
            </a>
            </div>
            @endforeach
        </div>
    </div>
@endSection