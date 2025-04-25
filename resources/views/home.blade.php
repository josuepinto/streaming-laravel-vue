@extends('layouts.disenyo')

@section('content')

<div class="container-fluid">
    <h1 class="mb-4 text-center">Piflix</h1>
    
    <!-- Banner principal -->
    <div id="movieCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($movies->take(20) as $index => $movie) 
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img src="{{ $movie->image }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="{{ $movie->title }}">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>{{ $movie->title }}</h2>
                        <p>{{ Str::limit($movie->description, 150) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Controles del carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#movieCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#movieCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div>

<!-- Películas debajo del carrusel -->
<div class="container mt-5">
    <h1 class="text-right mb-4">Latest Releases</h1>
    <div class="row">
        @foreach($series as $serie)
            <div class="col-md-4 p-3">
                <div class="card mb-3 h-100 d-flex flex-column">
                    <!-- Botón para ver detalles de la serie -->
                    <a href="{{ route('series.show', $serie->id) }}"><img src="{{ $serie->image }}" class="card-img-top" alt="{{ $serie->name }}"></a>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">{{ $serie->name }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @foreach($movies as $movie)
            <div class="col-md-4 p-3">
                <div class="card mb-3 h-100 d-flex flex-column">
                <a href="{{ route('watch', $movie->id) }}"><img src="{{ $movie->image }}" class="card-img-top" alt="{{ $movie->title }}"></a>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">{{ $movie->title }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
