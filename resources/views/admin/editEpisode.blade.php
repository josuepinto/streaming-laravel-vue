@extends('layouts.admin')

@section('admin_title', 'Edit Episode')

@section('content')
@if(session('success'))
    <div class="alert alert-success stream-alert admin-alert">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger stream-alert admin-alert">
        <ul class="mb-0">
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
            <h2>Edit Episode</h2>
            <p>Update episode details and optionally replace its banner image.</p>
        </div>
    </div>

    <form action="{{ route('episodes.update', $episode->id) }}" method="POST" enctype="multipart/form-data" class="admin-form-grid">
        @csrf
        @method('PUT')

        <div class="admin-form-group admin-form-group-full">
            <label for="title">Episode Title</label>
            <input type="text" name="title" id="title" class="form-control admin-form-input" value="{{ old('title', $episode->title) }}" required>
        </div>

        <div class="admin-form-group admin-form-group-full">
            <label for="video_url">Video URL</label>
            <input type="url" name="video_url" id="video_url" class="form-control admin-form-input" value="{{ old('video_url', $episode->video_url) }}" required>
        </div>

        @if($episode->image)
            <div class="admin-form-group admin-form-group-full">
                <label>Current Image</label>
                <img src="{{ asset('storage/' . $episode->image) }}" alt="Current episode image" class="admin-preview-image">
            </div>
        @endif

        <div class="admin-form-group admin-form-group-full">
            <label for="image">New Image</label>
            <input type="file" name="image" id="image" class="form-control admin-form-input" accept="image/*">
        </div>

        <div class="admin-form-actions">
            <button type="submit" class="btn poster-btn poster-btn-primary">Save Changes</button>
            <a href="{{ route('admin.seriesPanel') }}" class="btn poster-btn poster-btn-secondary">Back</a>
        </div>
    </form>
</section>
@endsection
