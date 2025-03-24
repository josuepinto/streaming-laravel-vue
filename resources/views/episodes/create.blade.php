@extends('layouts.disenyo')

@section('content')
    <h1>Añadir Episodio</h1>

    <form method="POST" action="{{ route('episodes.store') }}">
        @csrf
        <label>Selecciona una Serie:</label>
        <select name="serie_id" required>
            <option value="">-- Seleccionar --</option>
            @foreach($series as $serie)
                <option value="{{ $serie->id }}">{{ $serie->name }}</option>
            @endforeach
        </select>
        <br>

        <label>Título del Episodio:</label>
        <input type="text" name="title" required>
        <br>

        <label>Temporada:</label>
        <input type="number" name="season" required>
        <br>

        <label>Número de Episodio:</label>
        <input type="number" name="episode_number" required>
        <br>

        <label>URL del Video:</label>
        <input type="url" name="video_url" required>
        <br>

        <button type="submit">Guardar Episodio</button>
    </form>
@endsection
