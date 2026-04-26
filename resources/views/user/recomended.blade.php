@extends('layouts.disenyo')

@section('content')

@php
    use Illuminate\Support\Str;
@endphp

<div class="stream-catalog-page">
    <div class="container-fluid stream-page-wrap">
        <div class="catalog-header">
            <div>
                <span class="catalog-kicker">Recommended</span>
                <h1>Recommended For You</h1>
                <p>
                    A curated row of action-driven titles that fit the current PiFlix recommendation logic.
                </p>
            </div>
        </div>

        @if ($actionMovies->isEmpty())
            <div class="stream-empty-state">
                No movies are currently available in the recommended list.
            </div>
        @else
            <div class="catalog-grid">
                @foreach($actionMovies as $movie)
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
                                <p>{{ $movie->description }}</p>

                                <div class="catalog-tags">
                                    <span>{{ $movie->genre }}</span>
                                    <span>{{ $movie->year }}</span>
                                </div>
                            </div>

                            <div class="catalog-card-actions">
                                <a href="{{ route('watch', $movie->id) }}" class="btn poster-btn poster-btn-primary">Watch</a>
                                <a href="{{ route('favourite.movie.add', $movie->id) }}" class="btn poster-btn poster-btn-secondary">My List</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection
