@extends('layouts.admin')

@section('admin_title', 'Manage Series')

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
            <span class="catalog-kicker">Series</span>
            <h2>Series Catalogue</h2>
            <p>Search, manage and access each series episode panel.</p>
        </div>

        <a href="{{ route('series.create') }}" class="btn poster-btn poster-btn-primary">Add Series</a>
    </div>

    <form method="GET" action="{{ route('admin.seriesPanel') }}" class="admin-searchbar">
        <input
            type="text"
            name="search"
            class="form-control admin-search-input"
            placeholder="Search series by name..."
            value="{{ request('search') }}"
        >
        <button type="submit" class="btn poster-btn poster-btn-primary">Search</button>
        @if(request('search'))
            <a href="{{ route('admin.seriesPanel') }}" class="btn poster-btn poster-btn-secondary">Clear</a>
        @endif
    </form>

    <div class="admin-table-shell">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Poster</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actor</th>
                    <th>Director</th>
                    <th>Video</th>
                    <th>Episodes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($seriesList as $serie)
                    <tr>
                        <td>
                            <img
                                src="{{ str_starts_with($serie->image, 'series_images/')
                                        ? asset('storage/' . $serie->image)
                                        : asset($serie->image) }}"

                                alt="{{ $serie->name }}"
                                class="admin-thumb"
                            >
                        </td>
                        <td class="admin-cell-strong">{{ $serie->name }}</td>
                        <td>{{ Str::limit($serie->desc, 120) }}</td>
                        <td>{{ $serie->actor }}</td>
                        <td>{{ $serie->director }}</td>
                        <td>
                            <a href="{{ $serie->video_url }}" target="_blank" class="admin-inline-link">Open video</a>
                        </td>
                        <td><span class="admin-pill">{{ $serie->num_episode }} Episodes</span></td>
                        <td>
                            <div class="admin-actions admin-actions-column">
                                <a href="{{ route('series.edit', $serie->id) }}" class="btn poster-btn poster-btn-primary">Edit Series</a>
                                <a href="{{ route('admin.episodesPanel', $serie->id) }}" class="btn poster-btn poster-btn-secondary">Episodes</a>
                                <form action="{{ route('series.destroy', $serie->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn poster-btn poster-btn-danger" onclick="return confirm('Are you sure you want to delete this series?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="admin-empty-row">No series found for the current search.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
