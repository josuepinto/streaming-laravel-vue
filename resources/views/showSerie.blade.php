@extends('layouts.disenyo')

@section('content')
<div class="container mt-4">
    <h1>{{ $serie->name }}</h1>
    <p><strong>Director:</strong> {{ $serie->director }}</p>
    <p><strong>Actores:</strong> {{ $serie->actor }}</p>
    <p><strong>Descripción:</strong> {{ $serie->desc }}</p>
    <img src="{{ asset('storage/'.$serie->image) }}" alt="{{ $serie->name }}" class="img-fluid">

    <h3 class="mt-4">Episodios</h3>
    <ul>
        @foreach($serie->episodes as $episode)
            <li>
                <strong>{{ $episode->title }}</strong> - Temporada: {{ $episode->season }} - Episodio: {{ $episode->episode_number }}
                <a href="{{ $episode->video_url }}" target="_blank">Ver Episodio</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
