@extends('layouts.admin')

@section('admin_title', 'Manage Movies')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp

@if (session('success'))
    <div class="alert alert-success stream-alert admin-alert">
        {{ session('success') }}
    </div>
@endif

<section class="admin-panel-card">
    <div class="admin-section-heading">
        <div>
            <span class="catalog-kicker">Movies</span>
            <h2>Movie Catalogue</h2>
            <p>Review, edit and remove titles from the movie library.</p>
        </div>

        <a href="{{ route('addMovie') }}" class="btn poster-btn poster-btn-primary">Add Movie</a>
    </div>

    <div class="admin-table-shell">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Poster</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actor</th>
                    <th>Director</th>
                    <th>Genre</th>
                    <th>Year</th>
                    <th>Video</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movies as $movie)
                    <tr>
                        <td>
                            <img
                                src="{{ asset($movie->image) }}"
                                alt="{{ $movie->title }}"
                                class="admin-thumb"
                            >
                        </td>
                        <td class="admin-cell-strong">{{ $movie->title }}</td>
                        <td>{{ Str::limit($movie->description, 120) }}</td>
                        <td>{{ $movie->actor }}</td>
                        <td>{{ $movie->director }}</td>
                        <td><span class="admin-pill">{{ $movie->genre }}</span></td>
                        <td>{{ $movie->year }}</td>
                        <td>
                            <a href="{{ $movie->video_url }}" target="_blank" class="admin-inline-link">Open video</a>
                        </td>
                        <td>
                            <div class="admin-actions">
                                <form action="{{ route('editMovie', $movie->id) }}" method="GET">
                                    <button type="submit" class="btn poster-btn poster-btn-primary">Edit</button>
                                </form>
                                <form action="{{ route('deleteMovie', $movie->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn poster-btn poster-btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="admin-empty-row">No movies found in the catalogue.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
