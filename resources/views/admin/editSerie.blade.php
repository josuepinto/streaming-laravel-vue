@extends('layouts.admin')

@section('admin_title', 'Edit Series')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger stream-alert admin-alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<section class="admin-form-card">
    <div class="admin-section-heading">
        <div>
            <span class="catalog-kicker">Series</span>
            <h2>Edit Series</h2>
            <p>Update the selected series and keep its catalogue information current.</p>
        </div>
    </div>

    <form action="{{ route('series.update', $serie->id) }}" method="POST" enctype="multipart/form-data" class="admin-form-grid">
        @csrf
        @method('PUT')

        <div class="admin-form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control admin-form-input" value="{{ old('name', $serie->name) }}" required>
        </div>

        <div class="admin-form-group admin-form-group-full">
            <label for="desc">Description</label>
            <textarea name="desc" id="desc" class="form-control admin-form-input admin-form-textarea" required>{{ old('desc', $serie->desc) }}</textarea>
        </div>

        <div class="admin-form-group">
            <label for="actor">Actors</label>
            <input type="text" name="actor" id="actor" class="form-control admin-form-input" value="{{ old('actor', $serie->actor) }}" required>
        </div>

        <div class="admin-form-group">
            <label for="director">Director</label>
            <input type="text" name="director" id="director" class="form-control admin-form-input" value="{{ old('director', $serie->director) }}" required>
        </div>

        <div class="admin-form-group admin-form-group-full">
            <label for="video_url">Video URL</label>
            <input type="url" name="video_url" id="video_url" class="form-control admin-form-input" value="{{ old('video_url', $serie->video_url) }}" required>
        </div>

        <div class="admin-form-group">
            <label for="num_episode">Number of Episodes</label>
            <input type="number" name="num_episode" id="num_episode" class="form-control admin-form-input" value="{{ old('num_episode', $serie->num_episode) }}" required>
        </div>

        <div class="admin-form-group">
            <label for="image">New Image</label>
            <input type="file" name="image" id="image" class="form-control admin-form-input">
        </div>

        <div class="admin-form-actions">
            <button type="submit" class="btn poster-btn poster-btn-primary">Update Series</button>
            <a href="{{ route('admin.seriesPanel') }}" class="btn poster-btn poster-btn-secondary">Back</a>
        </div>
    </form>
</section>
@endsection
