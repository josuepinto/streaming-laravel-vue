@extends('layouts.disenyo')

@section('content')

@php
    use Illuminate\Support\Str;
@endphp
<div class="content mt-4">
    <h1 class="text-center mb-4">Movie List</h1>
    <div class="row">
        @foreach($moviesList as $movie)
        <div class="col-md-4 mb-4">
            <div class="card h-100 d-flex flex-column">
                <img src="{{ asset($movie->image) }}" class="card-img-top" alt="MovieImage">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h2 class="card-title">{{ $movie->title }}</h2>
                        <p class="card-text">{{ $movie->description }}</p>
                        <p class="card-text"><strong>Genre:</strong> {{ $movie->genre }}</p>
                        <p class="card-text"><strong>Year:</strong> {{ $movie->year }}</p>
                        <p class="card-text"><strong>Actor:</strong> {{ $movie->actor }}</p>
                        <p class="card-text"><strong>Director:</strong> {{ $movie->director }}</p>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('watch', $movie->id) }}" class="btn btn-primary mt-auto mx-auto">Watch Now</a>
                       <!-- Boton para añadir peli en lista de favouritos paginas-->

                        <a href="{{ route('favourite.add', $movie->id) }}" class="btn btn-info mt-auto mx-auto">Add to Favourite</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
