@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1>Editar Serie</h1>

    <form action="{{ route('series.update', $serie->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $serie->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="desc" class="form-label">Descripción:</label>
            <textarea name="desc" class="form-control" required>{{ old('desc', $serie->desc) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="actor" class="form-label">Actores:</label>
            <input type="text" name="actor" class="form-control" value="{{ old('actor', $serie->actor) }}" required>
        </div>

        <div class="mb-3">
            <label for="director" class="form-label">Director:</label>
            <input type="text" name="director" class="form-control" value="{{ old('director', $serie->director) }}" required>
        </div>

        <div class="mb-3">
            <label for="video_url" class="form-label">URL del Video:</label>
            <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $serie->video_url) }}" required>
        </div>

        <div class="mb-3">
            <label for="num_episode" class="form-label">Número de Capítulos:</label>
            <input type="number" name="num_episode" class="form-control" value="{{ old('num_episode', $serie->num_episode) }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Imagen nueva (opcional):</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Actualizar Serie</button>
    </form>
</div>
@endsection
