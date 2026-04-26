@extends('layouts.disenyo')

@section('content')

@php
    use Illuminate\Support\Str;

    $movieImage = Str::startsWith($movie->image, 'movies_images/')
        ? asset('storage/' . $movie->image)
        : asset($movie->image);
@endphp

<div class="stream-detail-page">
    <section class="detail-hero detail-hero-movie">
        <div class="detail-hero-backdrop">
            <img src="{{ $movieImage }}" alt="{{ $movie->title }}">
        </div>
        <div class="detail-hero-overlay"></div>

        <div class="container-fluid stream-page-wrap detail-hero-content">
            <div class="detail-poster">
                <img src="{{ $movieImage }}" alt="{{ $movie->title }}">
            </div>

            <div class="detail-copy">
                <span class="detail-kicker">Movie</span>
                <h1 class="detail-title">{{ $movie->title }}</h1>
                <p class="detail-meta">{{ $movie->year }} · {{ $movie->genre }} · {{ $movie->director }}</p>
                <p class="detail-description">{{ $movie->description }}</p>

                <div class="detail-actions">
                    @if($movieFavouriteId)
                        <form action="{{ route('favourite.destroy', $movieFavouriteId) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn hero-btn hero-btn-secondary">Remove from My List</button>
                        </form>
                    @else
                        <a href="{{ route('favourite.movie.add', $movie->id) }}" class="btn hero-btn hero-btn-secondary">Add to My List</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid stream-page-wrap detail-sections">
        @if (session('success'))
            <div class="alert alert-success stream-alert">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger stream-alert">{{ session('error') }}</div>
        @endif

        <section class="detail-panel">
            <div class="section-heading">
                <h2>Now Playing</h2>
                <p>Watch the selected movie directly from your catalogue.</p>
            </div>

            <div class="player-shell">
                <div class="ratio ratio-16x9 player-frame">
                    <iframe src="{{ $movie->video_url }}" allowfullscreen></iframe>
                </div>
            </div>
        </section>

        <section class="detail-grid">
            <article class="detail-info-card">
                <h3>Overview</h3>
                <p>{{ $movie->description }}</p>
            </article>

            <article class="detail-info-card">
                <h3>Details</h3>
                <ul class="detail-facts">
                    <li><span>Actor</span><strong>{{ $movie->actor }}</strong></li>
                    <li><span>Director</span><strong>{{ $movie->director }}</strong></li>
                    <li><span>Year</span><strong>{{ $movie->year }}</strong></li>
                    <li><span>Genre</span><strong>{{ $movie->genre }}</strong></li>
                </ul>
            </article>
        </section>
    </div>
</div>

@endsection
