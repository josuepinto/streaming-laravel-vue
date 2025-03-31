@extends('layouts.disenyo')

@section('content')
<div class="container mt-4">
    <h1 class="text-center">{{ $movie->title }}</h1>

    <div class="row mt-4">
        <!-- Información de la Película: Descripción, Género, Año -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <img src="{{ asset($movie->image) }}" class="card-img-top" alt="Movie Image">
                <div class="card-body">
                    <h5 class="card-title">Description:</h5>
                    <p class="card-text">{{ $movie->description }}</p>
                    <p class="card-text"><strong>Genre:</strong> {{ $movie->genre }}</p>
                    <p class="card-text"><strong>Year:</strong> {{ $movie->year }}</p>
                </div>
            </div>
        </div>

        <!-- Reproductor de Video (ocupa todo el ancho) -->
        <div class="col-md-12">
            <h3 class="text-center mb-4">Watch Now</h3>
            <div class="embed-responsive embed-responsive-16by9" style="height: 500px;">
                <iframe class="embed-responsive-item w-100 h-100" src="{{ $movie->video_url }}" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
@endsection
