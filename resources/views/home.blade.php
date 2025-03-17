@extends('layouts.disenyo')

@section('content')

<div class="container-fluid">
<h1 class="mb-4 text-center">Piflix</h1>
    <!-- Banner principal -->
    <div id="movieCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($movies->take(5) as $index => $movie) 
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img src="{{ $movie->image }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="{{ $movie->title }}">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>{{ $movie->title }}</h2>
                        <p>{{ Str::limit($movie->description, 150) }}</p>
                        <a href="#" class="btn btn-primary">Ver Ahora</a>
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

<div class="container mt-5">
    
    <div class="row">
        @foreach($movies as $movie)
            <div class="col-md-4">
                <div class="card mb-3">
                    <img src="{{ $movie->image }}" class="card-img-top" alt="{{ $movie->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $movie->title }}</h5>
                        <p class="card-text">{{ Str::limit($movie->description, 100) }}</p>
                        <p><strong>Género:</strong> {{ $movie->genre }}</p>
                        <p><strong>Año:</strong> {{ $movie->year }}</p>
                        <a href="#" class="btn btn-primary">Ver Película</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
