@extends('layouts.disenyo')

@section('content')

<div class="container">
    <h1 class="mb-4">Películas Destacadas</h1>
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
