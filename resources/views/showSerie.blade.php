@extends('layouts.disenyo')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-4">
            <img src="{{ asset('storage/' . $serie->image) }}" alt="{{ $serie->name }}" class="img-fluid rounded shadow">
        </div>
        <div class="col-md-8">
            <h1 class="display-4">{{ $serie->name }}</h1>
            <p><strong>Director:</strong> {{ $serie->director }}</p>
            <p><strong>Actores:</strong> {{ $serie->actor }}</p>
            <p><strong>Descripción:</strong> {{ $serie->desc }}</p>
        </div>
    </div>

    <div class="mb-4">
        <h3>Filtrar por Temporada</h3>
        <form method="GET" action="{{ route('series.show', $serie->id) }}" class="form-inline">
            <div class="form-group">
                <select name="season" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Todas las temporadas --</option>
                    @foreach($seasons as $season)
                        <option value="{{ $season }}" {{ $season == $seasonFilter ? 'selected' : '' }}>
                            Temporada {{ $season }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <h3 class="mb-3">Episodios</h3>
    @if($episodes->count())
        <div class="row">
            @foreach($episodes as $episode)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                        @if($episode->image)
    <img src="{{ asset('storage/' . $episode->image) }}"
         alt="Banner del episodio"
         class="card-img-top object-fit-cover"
         style="height: 400px; width: 100%; object-fit: cover;">
@endif


                            <h5 class="card-title">{{ $episode->title }}</h5>
                            <p class="card-text mb-1">Temporada: {{ $episode->season }}</p>
                            <p class="card-text mb-3">Episodio: {{ $episode->episode_number }}</p>
                            <a href="{{ $episode->video_url }}" target="_blank" class="mt-auto btn btn-primary">Ver Episodio</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">No hay episodios para esta temporada.</div>
    @endif
</div>
@endsection
