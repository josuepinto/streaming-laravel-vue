@extends('layouts.admin')

@section('content')
<header class="banner mt-5 text-center">
    <h1>Añadir nuevo episodio</h1>
</header>

    <form method="POST" action="{{ route('episodes.store') }}" class="container mt-5">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="serie_id">Selecciona una Serie:</label>
                <select id="serie_id" name="serie_id" class="form-control" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($series as $serie)
                        <option value="{{ $serie->id }}">{{ $serie->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="title">Título del Episodio:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="season">Temporada:</label>
                <input type="number" id="season" name="season" class="form-control" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="episode_number">Número de Episodio:</label>
                <input type="number" id="episode_number" name="episode_number" class="form-control" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="video_url">URL del Video:</label>
                <input type="url" id="video_url" name="video_url" class="form-control" required>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Guardar Episodio</button>
</form>
@endsection
