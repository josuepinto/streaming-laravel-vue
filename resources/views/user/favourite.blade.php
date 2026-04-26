@extends('layouts.disenyo')

@section('content')
<div class="stream-catalog-page">
    <div class="container-fluid stream-page-wrap">
        <div class="catalog-header">
            <div>
                <span class="catalog-kicker">Personal List</span>
                <h1>My Favourites</h1>
                <p>Your saved movies and series, collected in one place.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success stream-alert">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger stream-alert">{{ session('error') }}</div>
        @endif

        @if($favourites->isEmpty())
            <div class="stream-empty-state">
                You have no favourite movies or series yet.
            </div>
        @else
            <div class="catalog-grid">
                @foreach($favourites as $fav)
                    @php
                        $item = $fav->favouritable;
                    @endphp

                    @if($item)
                        <article class="catalog-card">
                            <a
                                href="{{ $item instanceof \App\Models\Movie ? route('watch', $item->id) : route('series.show', $item->id) }}"
                                class="catalog-card-media"
                            >
                                <img src="{{ asset($item->image) }}" alt="{{ $item->title ?? $item->name }}">
                            </a>

                            <div class="catalog-card-body">
                                <div class="catalog-card-copy">
                                    <h2>{{ $item->title ?? $item->name }}</h2>
                                    <p>{{ \Illuminate\Support\Str::limit($item->description ?? $item->desc, 130) }}</p>

                                    <div class="catalog-tags">
                                        <span>{{ $item instanceof \App\Models\Movie ? 'Movie' : 'Series' }}</span>
                                    </div>
                                </div>

                                <div class="catalog-card-actions">
                                    @if($item instanceof \App\Models\Movie)
                                        <a href="{{ route('watch', $item->id) }}" class="btn poster-btn poster-btn-primary">Watch</a>
                                    @elseif($item instanceof \App\Models\Serie)
                                        <a href="{{ route('series.show', $item->id) }}" class="btn poster-btn poster-btn-primary">Details</a>
                                    @endif

                                    <form action="{{ route('favourite.destroy', $fav->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn poster-btn poster-btn-danger">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
