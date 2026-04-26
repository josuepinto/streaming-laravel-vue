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
                <h1>Series</h1>
                <p>Explore your full series collection with a richer visual presentation.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success stream-alert">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger stream-alert">{{ session('error') }}</div>
        @endif

        <div class="catalog-grid">
            @foreach($seriesList as $serie)
                @php
                    $serieImage = Str::startsWith($serie->image, 'series_images/')
                        ? asset('storage/' . $serie->image)
                        : asset($serie->image);
                @endphp

                <article class="catalog-card">
                    <a href="{{ route('series.show', $serie->id) }}" class="catalog-card-media">
                        <img src="{{ $serieImage }}" alt="{{ $serie->name }}">
                    </a>

                    <div class="catalog-card-body">
                        <div class="catalog-card-copy">
                            <h2>{{ $serie->name }}</h2>
                            <p>{{ Str::limit($serie->desc, 130) }}</p>

                            <div class="catalog-tags">
                                <span>{{ $serie->director }}</span>
                                <span>{{ $serie->num_episode }} Episodes</span>
                            </div>
                        </div>

                        <div class="catalog-card-actions">
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
    </div>
</div>

@endsection
