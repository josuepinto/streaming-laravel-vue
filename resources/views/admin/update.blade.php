@extends('layouts.admin')

@section('admin_title', 'Edit Movie')

@section('content')
@if (session('success'))
    <div class="alert alert-success stream-alert admin-alert">
        {{ session('success') }}
    </div>
@endif

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
            <span class="catalog-kicker">Movies</span>
            <h2>Edit Movie</h2>
            <p>Update the selected movie entry.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('updateMovie', $movie->id) }}" enctype="multipart/form-data" class="admin-form-grid">
        @csrf
        @method('PUT')

        <div class="admin-form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control admin-form-input" value="{{ old('title', $movie->title) }}">
        </div>

        <div class="admin-form-group admin-form-group-full">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control admin-form-input admin-form-textarea">{{ old('description', $movie->description) }}</textarea>
        </div>

        <div class="admin-form-group">
            <label for="actor">Actor</label>
            <input type="text" name="actor" id="actor" class="form-control admin-form-input" value="{{ old('actor', $movie->actor) }}">
        </div>

        <div class="admin-form-group">
            <label for="director">Director</label>
            <input type="text" name="director" id="director" class="form-control admin-form-input" value="{{ old('director', $movie->director) }}">
        </div>

        <div class="admin-form-group">
            <label for="genre">Genre</label>
            <input type="text" name="genre" id="genre" class="form-control admin-form-input" value="{{ old('genre', $movie->genre) }}">
        </div>

        <div class="admin-form-group">
            <label for="year">Year</label>
            <input type="text" name="year" id="year" class="form-control admin-form-input" value="{{ old('year', $movie->year) }}">
        </div>

        <div class="admin-form-group admin-form-group-full">
            <label for="video_url">Video URL</label>
            <input type="text" name="video_url" id="video_url" class="form-control admin-form-input" value="{{ old('video_url', $movie->video_url) }}">
        </div>

        <div class="admin-form-group admin-form-group-full">
            <label for="image">New Poster Image</label>
            <input type="file" name="image" id="image" class="form-control admin-form-input">
        </div>

        <div class="admin-form-actions">
            <button type="submit" class="btn poster-btn poster-btn-primary">Update Movie</button>
            <a href="{{ route('adminPanel') }}" class="btn poster-btn poster-btn-secondary">Back</a>
        </div>
    </form>
</section>
@endsection
