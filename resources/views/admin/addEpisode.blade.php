@extends('layouts.admin')

@section('admin_title', 'Add Episode')

@section('content')
@if(session('success'))
    <div class="alert alert-success stream-alert admin-alert">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger stream-alert admin-alert">
        <strong>Please review the errors below:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<section class="admin-form-card">
    <div class="admin-section-heading">
        <div>
            <span class="catalog-kicker">Episodes</span>
            <h2>Add a New Episode</h2>
            <p>Select a series and season, then complete the episode details.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('addEpisode') }}" class="admin-form-grid admin-form-grid-compact">
        @csrf

        <div class="admin-form-group">
            <label for="serie_id">Select Series</label>
            <select id="serie_id" name="serie_id" class="form-control admin-form-input" onchange="this.form.submit()">
                <option value="">-- Select --</option>
                @foreach($series as $serie)
                    <option value="{{ $serie->id }}" {{ old('serie_id', $selectedSerie?->id) == $serie->id ? 'selected' : '' }}>
                        {{ $serie->name }}
                    </option>
                @endforeach
            </select>
        </div>

        @if($selectedSerie && $seasons->count())
            <div class="admin-form-group">
                <label for="season">Select Season</label>
                <select id="season" name="season" class="form-control admin-form-input" onchange="this.form.submit()">
                    @foreach($seasons as $season)
                        <option value="{{ $season }}" {{ old('season', $selectedSeason) == $season ? 'selected' : '' }}>
                            Season {{ $season }}
                        </option>
                    @endforeach
                    <option value="{{ $seasons->max() + 1 }}" {{ old('season', $selectedSeason) == $seasons->max() + 1 ? 'selected' : '' }}>
                        New Season ({{ $seasons->max() + 1 }})
                    </option>
                </select>
            </div>
        @endif

        @if(isset($autoMessage))
            <div class="admin-helper-box admin-form-group-full">
                {{ $autoMessage }}
            </div>
        @endif
    </form>
</section>

@if($selectedSerie && $selectedSeason)
<section class="admin-form-card admin-form-card-spaced">
    <div class="admin-section-heading">
        <div>
            <span class="catalog-kicker">Episode Form</span>
            <h2>{{ $selectedSerie->name }}</h2>
            <p>Season {{ $selectedSeason }} · Suggested episode number: {{ $nextEpisode }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('episodes.store') }}" enctype="multipart/form-data" class="admin-form-grid">
        @csrf
        <input type="hidden" name="serie_id" value="{{ $selectedSerie->id }}">
        <input type="hidden" name="season" value="{{ $selectedSeason }}">
        <input type="hidden" name="episode_number" value="{{ $nextEpisode }}">

        <div class="admin-form-group admin-form-group-full">
            <label for="title">Episode Title</label>
            <input type="text" id="title" name="title" class="form-control admin-form-input" value="{{ old('title') }}">
        </div>

        <div class="admin-form-group admin-form-group-full">
            <label for="video_url">Video URL</label>
            <input type="url" id="video_url" name="video_url" class="form-control admin-form-input" value="{{ old('video_url') }}">
        </div>

        <div class="admin-form-group admin-form-group-full">
            <label for="image">Episode Banner</label>
            <input type="file" id="image" name="image" class="form-control admin-form-input" accept="image/*">
        </div>

        <div class="admin-form-actions">
            <button type="submit" class="btn poster-btn poster-btn-primary">Save Episode</button>
            <a href="{{ route('admin.seriesPanel') }}" class="btn poster-btn poster-btn-secondary">Back</a>
        </div>
    </form>
</section>
@endif
@endsection
