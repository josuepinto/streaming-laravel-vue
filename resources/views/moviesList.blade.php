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
            <div class="card">
                <img src="{{ Str::startsWith($movie->image, 'http') ? $movie->image : asset('image/' . $movie->image) }}" class="card-img-top" alt="MovieImage">
                <div class="card-body">
                    <h2 class="card-title">{{ $movie->title }}</h2>
                    <p class="card-text">{{ $movie->description }}</p>
                    <p class="card-text"><strong>Actor:</strong>{{ $movie->actor }}</p>
                    <p class="card-text"><strong>Director:</strong>{{ $movie->director }}</p>
                    <p class="card-text"><strong>Genre:</strong> {{ $movie->genre }}</p>
                    <p class="card-text"><strong>Year:</strong> {{ $movie->year }}</p>
                    <a href="{{ route('watch', ['movie' => $movie->id]) }}" class="btn btn-primary">Watch Now</a>
                </div>
            </div>
        </div>
        @endforeach
</div>
@endsection
