@extends('layouts.disenyo')
@section('content')
    <h1>Lista de Series</h1>
    <a href="{{ route('series.create') }}">Añadir Nueva Serie</a>
    <a href="{{ route('episodes.create') }}">Añadir Episodio</a>

    <ul>
        @foreach($series as $serie)
            <li>
                <strong>{{ $serie->name }}</strong> ({{ $serie->num_episode }} episodios)
                <p>{{ $serie->desc }}</p>
                <ul>
                    @foreach($serie->episodes as $episode)
                        <li>Temporada {{ $episode->season }} - Episodio {{ $episode->episode_number }}: {{ $episode->title }}</li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
@endsection
