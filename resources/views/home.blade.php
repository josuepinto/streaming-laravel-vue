@extends('layouts.disenyo')

@section('content')

@php
    // Usamos la clase Str para verificar si una ruta de imagen comienza con 'movies_images/'
    use Illuminate\Support\Str;
@endphp

<div class="container-fluid">
    <h1 class="mb-4 text-center">Piflix</h1>
    <h2>Welcome {{ $userName }} to Piflix </h2>
    <!-- Banner principal -->
    <div id="movieCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($movies->take(20) as $index => $movie) 
                @php
                    // ✅ Si la imagen es de storage (subida), usamos asset('storage/...').
                    // ✅ Si es una imagen de seeders/factory (por ejemplo en public/image/...), la usamos directamente.
                    $movieImage = Str::startsWith($movie->image, 'movies_images/') ? asset('storage/' . $movie->image) : asset($movie->image);
                @endphp
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img src="{{ $movieImage }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="{{ $movie->title }}">
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

<!-- Películas & series debajo del carrusel -->
<div class="container mt-5">
    @if ($movies->isEmpty() && $series->isEmpty())
        <div class="alert alert-warning text-center">
            No movies or series found for your search.
        </div>
    @endif

    <h1 class="text-right mb-4">Latest Releases</h1>

    <div class="row">
        @foreach($series as $serie)
            <div class="col-md-4 p-3">
                <div class="card mb-3 h-100 d-flex flex-column">
                    <a href="{{ route('series.show', $serie->id) }}">
                        <!-- ✅ Las imágenes de series siempre van por storage, porque se suben por formulario -->
                        <img src="{{ asset('storage/' . $serie->image) }}"
                             class="card-img-top"
                             alt="{{ $serie->name }}"
                             style="height: 300px; object-fit: cover;">
                    </a>
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
                    <a href="{{ route('watch', $movie->id) }}">
                        @php
                            // ✅ Mismo tratamiento que el carrusel: si es de storage, se carga con asset('storage/...'), si no, directo.
                            $movieImage = Str::startsWith($movie->image, 'movies_images/') ? asset('storage/' . $movie->image) : asset($movie->image);
                        @endphp
                        <img src="{{ $movieImage }}"
                             class="card-img-top"
                             alt="{{ $movie->title }}"
                             style="height: 300px; object-fit: cover;">
                    </a>
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
