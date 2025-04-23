
@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Añadir nuevo episodio</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Paso 1: Elegir serie y temporada --}}
    <form method="POST" action="{{ route('addEpisode') }}">
        @csrf
        <div class="form-group">
            <label for="serie_id">Selecciona una Serie:</label>
            <select id="serie_id" name="serie_id" class="form-control" required onchange="this.form.submit()">
                <option value="">-- Seleccionar --</option>
                @foreach($series as $serie)
                    <option value="{{ $serie->id }}" {{ old('serie_id', $selectedSerie?->id) == $serie->id ? 'selected' : '' }}>{{ $serie->name }}</option>
                @endforeach
            </select>
        </div>

        @if($selectedSerie)
            <div class="form-group">
                <label for="season">Selecciona una Temporada:</label>
                <select id="season" name="season" class="form-control" required onchange="this.form.submit()">
                    @foreach($seasons as $season)
                        <option value="{{ $season }}" {{ old('season', $selectedSeason) == $season ? 'selected' : '' }}>Temporada {{ $season }}</option>
                    @endforeach
                    <option value="{{ $seasons->max() + 1 }}" {{ old('season', $selectedSeason) == $seasons->max() + 1 ? 'selected' : '' }}>Nueva Temporada ({{ $seasons->max() + 1 }})</option>
                </select>
            </div>
        @endif
    </form>

    @if($selectedSerie && $selectedSeason)
    {{-- Paso 2: Completar información del episodio --}}
    <form method="POST" action="{{ route('episodes.store') }}">
        @csrf
        <input type="hidden" name="serie_id" value="{{ $selectedSerie->id }}">
        <input type="hidden" name="season" value="{{ $selectedSeason }}">
        <input type="hidden" name="episode_number" value="{{ $nextEpisode }}">

        <div class="form-group">
            <label for="title">Título del Episodio:</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="video_url">URL del Video:</label>
            <input type="url" id="video_url" name="video_url" class="form-control" required>
        </div>

        <p><strong>Número de Episodio Sugerido:</strong> {{ $nextEpisode }}</p>

        <button type="submit" class="btn btn-success mt-3">Guardar Episodio</button>
    </form>
    @endif
</div>
@endsection
