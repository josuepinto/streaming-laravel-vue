@extends('layouts.admin')

@section('admin_title', 'Manage Episodes')

@section('content')
@if(session('success'))
    <div class="alert alert-success stream-alert admin-alert">
        {{ session('success') }}
    </div>
@endif

<section class="admin-panel-card">
    <div class="admin-section-heading">
        <div>
            <span class="catalog-kicker">Episodes</span>
            <h2>{{ $serie->name }}</h2>
            <p>Manage all registered episodes for this series.</p>
        </div>

        <form method="POST" action="{{ route('addEpisode') }}">
            @csrf
            <input type="hidden" name="serie_id" value="{{ $serie->id }}">
            <button type="submit" class="btn poster-btn poster-btn-primary">Add Episode</button>
        </form>
    </div>

    <div class="admin-table-shell">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Season</th>
                    <th>Episode</th>
                    <th>Video</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($episodes as $episode)
                    <tr>
                        <td>
                            <img
                                src="{{ $episode->image ? asset('storage/' . $episode->image) : asset($serie->image) }}"
                                alt="{{ $episode->title }}"
                                class="admin-thumb"
                            >
                        </td>
                        <td class="admin-cell-strong">{{ $episode->title }}</td>
                        <td><span class="admin-pill">Season {{ $episode->season }}</span></td>
                        <td>{{ $episode->episode_number }}</td>
                        <td>
                            <a href="{{ $episode->video_url }}" target="_blank" class="admin-inline-link">Open video</a>
                        </td>
                        <td>
                            <div class="admin-actions">
                                <a href="{{ route('episodes.edit', $episode->id) }}" class="btn poster-btn poster-btn-primary">Edit</a>
                                <form method="POST" action="{{ route('episodes.destroy', $episode->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn poster-btn poster-btn-danger" onclick="return confirm('Delete this episode?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="admin-empty-row">No episodes registered for this series.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
