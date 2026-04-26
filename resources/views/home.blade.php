@extends('layouts.disenyo')

@section('content')

@php
    use Illuminate\Support\Str;

    $featuredMovies = $movies->take(5)->values();
@endphp

<div class="stream-home">
    @if (session('error'))
        <div class="container-fluid stream-page-wrap">
            <div class="alert alert-danger stream-alert" role="alert">
                {{ session('error') }}
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="container-fluid stream-page-wrap">
            <div class="alert alert-success stream-alert" role="alert">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if ($featuredMovies->isNotEmpty())
        <section class="hero-spotlight" data-hero-spotlight data-interval="20000">
            <div class="hero-slider">
                @foreach($featuredMovies as $index => $featuredMovie)
                    @php
                        $featuredImage = Str::startsWith($featuredMovie->image, 'movies_images/')
                            ? asset('storage/' . $featuredMovie->image)
                            : asset($featuredMovie->image);
                    @endphp

                    <article class="hero-slide {{ $index === 0 ? 'is-active' : '' }}" data-hero-slide>
                        <div class="hero-backdrop">
                            <img src="{{ $featuredImage }}" alt="{{ $featuredMovie->title }}">
                        </div>

                        <div class="hero-overlay"></div>

                        <div class="container-fluid stream-page-wrap hero-content">
                            <div class="hero-copy">
                                <span class="hero-kicker">PiFlix Featured</span>
                                <h1 class="hero-title">{{ $featuredMovie->title }}</h1>
                                <p class="hero-meta">
                                    {{ $featuredMovie->year }} · {{ $featuredMovie->genre }} · {{ $featuredMovie->director }}
                                </p>
                                <p class="hero-description">
                                    {{ Str::limit($featuredMovie->description, 220) }}
                                </p>

                                <div class="hero-actions">
                                    <a href="{{ route('watch', $featuredMovie->id) }}" class="btn hero-btn hero-btn-primary">
                                        Watch now
                                    </a>

                                    @if(isset($movieFavouriteIds[$featuredMovie->id]))
                                        <form action="{{ route('favourite.destroy', $movieFavouriteIds[$featuredMovie->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn hero-btn hero-btn-secondary">Remove from My List</button>
                                        </form>
                                    @else
                                        <a href="{{ route('favourite.movie.add', $featuredMovie->id) }}" class="btn hero-btn hero-btn-secondary">
                                            Add to My List
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if($featuredMovies->count() > 1)
                <button type="button" class="hero-nav hero-nav-prev" data-hero-prev aria-label="Previous featured item">
                    <span>&lsaquo;</span>
                </button>

                <button type="button" class="hero-nav hero-nav-next" data-hero-next aria-label="Next featured item">
                    <span>&rsaquo;</span>
                </button>

                <div class="hero-indicators container-fluid stream-page-wrap">
                    @foreach($featuredMovies as $index => $featuredMovie)
                        <button
                            type="button"
                            class="hero-indicator {{ $index === 0 ? 'is-active' : '' }}"
                            data-hero-indicator
                            data-index="{{ $index }}"
                            aria-label="Go to featured item {{ $index + 1 }}"
                        ></button>
                    @endforeach
                </div>
            @endif
        </section>
    @endif

    <div class="container-fluid stream-page-wrap stream-sections">
        <section class="stream-section">
            <div class="section-heading">
                <h2>Trending Series</h2>
                <p>Series your catalogue is spotlighting right now.</p>
            </div>

            @if($series->isEmpty())
                <div class="stream-empty-state">
                    No series found for your current search.
                </div>
            @else
                <div class="poster-row">
                    @foreach($series as $serie)
                        @php
                            $serieImage = Str::startsWith($serie->image, 'series_images/')
                                ? asset('storage/' . $serie->image)
                                : asset($serie->image);
                        @endphp

                        <article class="poster-card">
                            <a href="{{ route('series.show', $serie->id) }}" class="poster-media">
                                <img src="{{ $serieImage }}" alt="{{ $serie->name }}">
                            </a>

                            <div class="poster-overlay">
                                <h3>{{ $serie->name }}</h3>
                                <p>{{ Str::limit($serie->desc, 110) }}</p>

                                <div class="poster-actions">
                                    <a href="{{ route('series.show', $serie->id) }}" class="btn poster-btn poster-btn-primary">Details</a>

                                    @if(isset($serieFavouriteIds[$serie->id]))
                                        <form action="{{ route('favourite.destroy', $serieFavouriteIds[$serie->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn poster-btn poster-btn-danger">Remove</button>
                                        </form>
                                    @else
                                        <a href="{{ route('favourite.serie.add', $serie->id) }}" class="btn poster-btn poster-btn-secondary">My List</a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="stream-section">
            <div class="section-heading">
                <h2>Popular Movies</h2>
                <p>A sharper and more cinematic catalogue experience.</p>
            </div>

            @if($movies->isEmpty())
                <div class="stream-empty-state">
                    No movies found for your current search.
                </div>
            @else
                <div class="poster-row">
                    @foreach($movies as $movie)
                        @php
                            $movieImage = Str::startsWith($movie->image, 'movies_images/')
                                ? asset('storage/' . $movie->image)
                                : asset($movie->image);
                        @endphp

                        <article class="poster-card">
                            <a href="{{ route('watch', $movie->id) }}" class="poster-media">
                                <img src="{{ $movieImage }}" alt="{{ $movie->title }}">
                            </a>

                            <div class="poster-overlay">
                                <h3>{{ $movie->title }}</h3>
                                <p>{{ Str::limit($movie->description, 110) }}</p>

                                <div class="poster-actions">
                                    <a href="{{ route('watch', $movie->id) }}" class="btn poster-btn poster-btn-primary">Play</a>

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
            @endif
        </section>
    </div>
</div>

@endsection
