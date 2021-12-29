@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            @foreach($cameras as $camera)
                <div class="card col-3 m-3">
                    <img class="card-img-top" src="/img/{{ $camera->file }}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{ $camera->title }}</h5>
                        <p class="card-text">
                            {{ $camera->body }}
                        </p>
                        <a href="/show/{{$camera->id}}" class="btn btn-primary">
                            <i class="fa fa-eye"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endSection