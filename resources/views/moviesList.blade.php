@extends('layouts.disenyo')

@section('content')
<div class="content mt-4">
    <h1 class="text-center mb-4">Movie List</h1>
    <div class="row">
        @foreach($moviesList as $movie)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset($movie->image) }}" class="card-img-top" alt="Berlin">
                <div class="card-body">
                    <h2 class="card-title">{{ $movie->title }}</h2>
                    <p class="card-text">{{ $movie->description }}</p>
                    <p class="card-text"><strong>Genre:</strong> {{ $movie->genre }}</p>
                    <p class="card-text"><strong>Year:</strong> {{ $movie->year }}</p>
                    <a href="{{$movie->video_url}}" class="btn btn-primary">Watch Now</a>
                </div>
            </div>
        </div>
        @endforeach
</div>
@endsection