@extends('layouts.disenyo')

@section('content')

@php
    use Illuminate\Support\Str;

    $serieImagePath = Str::startsWith($serie->image, 'series_images/')
        ? asset('storage/' . $serie->image)
        : asset($serie->image);
@endphp

<div class="stream-detail-page">
    <section class="detail-hero detail-hero-series">
        <div class="detail-hero-backdrop">
            <img src="{{ $serieImagePath }}" alt="{{ $serie->name }}">
        </div>
        <div class="detail-hero-overlay"></div>

        <div class="container-fluid stream-page-wrap detail-hero-content">
            <div class="detail-poster">
                <img src="{{ $serieImagePath }}" alt="{{ $serie->name }}">
            </div>

            <div class="detail-copy">
                <span class="detail-kicker">Series</span>
                <h1 class="detail-title">{{ $serie->name }}</h1>
                <p class="detail-meta">{{ $serie->director }} · {{ $serie->num_episode }} Episodes</p>
                <p class="detail-description">{{ $serie->desc }}</p>

                <div class="detail-actions">
                    @if($serieFavouriteId)
                        <form action="{{ route('favourite.destroy', $serieFavouriteId) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn hero-btn hero-btn-secondary">Remove from My List</button>
                        </form>
                    @else
                        <a href="{{ route('favourite.serie.add', $serie->id) }}" class="btn hero-btn hero-btn-secondary">Add to My List</a>
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
                <h2>Series Details</h2>
                <p>Browse episodes and filter the season catalogue.</p>
            </div>

            <div class="detail-filter-bar">
                <form method="GET" action="{{ route('series.show', $serie->id) }}">
                    <select name="season" class="form-select detail-season-select" onchange="this.form.submit()">
                        <option value="">All seasons</option>
                        @foreach($seasons as $season)
                            <option value="{{ $season }}" {{ $season == $seasonFilter ? 'selected' : '' }}>
                                Season {{ $season }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </section>

        <section class="stream-section">
            <div class="section-heading">
                <h2>Episodes</h2>
                <p>Season-based episode browsing for a cleaner viewing experience.</p>
            </div>

            @if($episodes->count())
                <div class="episode-grid">
                    @foreach($episodes as $episode)
                        @php
                            $episodeImagePath = Str::startsWith($episode->image, 'episodes/')
                                ? asset('storage/' . $episode->image)
                                : asset($episode->image);
                        @endphp

                        <article class="episode-card">
                            @if($episode->image)
                                <div class="episode-card-media">
                                    <img src="{{ $episodeImagePath }}" alt="{{ $episode->title }}">
                                </div>
                            @endif

                            <div class="episode-card-body">
                                <div>
                                    <h3>{{ $episode->title }}</h3>
                                    <p>Season {{ $episode->season }} · Episode {{ $episode->episode_number }}</p>
                                </div>

                                <a href="{{ $episode->video_url }}" target="_blank" class="btn poster-btn poster-btn-primary">Watch Episode</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="stream-empty-state">
                    No episodes available for the selected season.
                </div>
            @endif
        </section>
    </div>
</div>

@endsection
