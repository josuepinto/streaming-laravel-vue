@extends('layouts.disenyo')

@section('content')

@php
    use Illuminate\Support\Str;
@endphp

<div class="stream-catalog-page">
    <div class="container-fluid stream-page-wrap">
        <div class="catalog-header">
            <div>
                <span class="catalog-kicker">Catalogue</span>
                <h1>Movies</h1>
                <p>Browse the full movie library with a cleaner, streaming-inspired presentation.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success stream-alert">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger stream-alert">{{ session('error') }}</div>
        @endif

        <div class="catalog-grid">
            @foreach($moviesList as $movie)
                @php
                    $movieImage = Str::startsWith($movie->image, 'movies_images/')
                        ? asset('storage/' . $movie->image)
                        : asset($movie->image);
                @endphp

                <article class="catalog-card">
                    <a href="{{ route('watch', $movie->id) }}" class="catalog-card-media">
                        <img src="{{ $movieImage }}" alt="{{ $movie->title }}">
                    </a>

                    <div class="catalog-card-body">
                        <div class="catalog-card-copy">
                            <h2>{{ $movie->title }}</h2>
                            <p>{{ Str::limit($movie->description, 130) }}</p>

                            <div class="catalog-tags">
                                <span>{{ $movie->genre }}</span>
                                <span>{{ $movie->year }}</span>
                            </div>
                        </div>

                        <div class="catalog-card-actions">
                            <a href="{{ route('watch', $movie->id) }}" class="btn poster-btn poster-btn-primary">Watch</a>

                            @if(isset($movieFavouriteIds[$movie->id]))
                                <form action="{{ route('favourite.destroy', $movieFavouriteIds[$movie->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn poster-btn poster-btn-danger">Remove</button>
                                </form>
                            @else
                                <a href="{{ route('favourite.movie.add', $movie->id) }}" class="btn poster-btn poster-btn-secondary">My List</a>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</div>

@endsection
