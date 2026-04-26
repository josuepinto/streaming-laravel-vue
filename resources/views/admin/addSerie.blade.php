@extends('layouts.admin')

@section('admin_title', 'Add Series')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger stream-alert admin-alert">
        <strong>Please review the fields below:</strong>
        <ul class="mb-0 mt-2">
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
            <h2>Add a New Series</h2>
            <p>Create a new series entry with its core catalogue information.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('series.store') }}" enctype="multipart/form-data" class="admin-form-grid">
        @csrf

        <div class="admin-form-group">
            <label for="name">Series Name</label>
            <input type="text" id="name" name="name" class="form-control admin-form-input" value="{{ old('name') }}">
        </div>

        <div class="admin-form-group admin-form-group-full">
            <label for="desc">Description</label>
            <textarea id="desc" name="desc" class="form-control admin-form-input admin-form-textarea">{{ old('desc') }}</textarea>
        </div>

        <div class="admin-form-group">
            <label for="actor">Actors</label>
            <input type="text" id="actor" name="actor" class="form-control admin-form-input" value="{{ old('actor') }}">
        </div>

        <div class="admin-form-group">
            <label for="director">Director</label>
            <input type="text" id="director" name="director" class="form-control admin-form-input" value="{{ old('director') }}">
        </div>

        <div class="admin-form-group admin-form-group-full">
            <label for="video_url">Video URL</label>
            <input type="url" id="video_url" name="video_url" class="form-control admin-form-input" value="{{ old('video_url') }}">
        </div>

        <div class="admin-form-group">
            <label for="num_episode">Number of Episodes</label>
            <input type="number" id="num_episode" name="num_episode" class="form-control admin-form-input" value="{{ old('num_episode') }}">
        </div>

        <div class="admin-form-group">
            <label for="image">Series Image</label>
            <input type="file" id="image" name="image" class="form-control admin-form-input" accept="image/*">
        </div>

        <div class="admin-form-actions">
            <button type="submit" class="btn poster-btn poster-btn-primary">Save Series</button>
            <a href="{{ route('admin.seriesPanel') }}" class="btn poster-btn poster-btn-secondary">Cancel</a>
        </div>
    </form>
</section>
@endsection
