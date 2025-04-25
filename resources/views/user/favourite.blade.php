@extends('layouts.disenyo')
@section('content')
<div class="content mt-4">
    <h1 class="text-center mb-4">My Favourites</h1>

    @if($favourites->isEmpty())
        <div class="text-center">
            <h4>No movies in favourites list.</h4>
        </div>
    @else
        <div class="row">
            @foreach($favourites as $fav)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset($fav->movie->image) }}"  class="card-img-top" alt="MovieImage">
                        <div class="card-body">
                            <h5>{{ $fav->movie->title }}</h5>
                            <p>{{ $fav->movie->description }}</p>
                            <a href="{{ route('watch', $fav->movie->id) }}" class="btn btn-primary">Watch Now</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection