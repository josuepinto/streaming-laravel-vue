@extends('layouts.admin')

@section('content')
<header class="banner mt-5">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h1>Admin Panel - Series</h1>
    <br/>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Imagen</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Actor</th>
                <th scope="col">Director</th>
                <th scope="col">URL Video</th>
                <th scope="col">Nº Capítulos</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
    @foreach($seriesList as $serie)
        <tr>
            <td>
                <img src="{{ asset('storage/' . $serie->image) }}" class="img-fluid img-thumbnail" alt="{{ $serie->name }}" style="width: 150px; height: auto;">
            </td>
            <td>{{ $serie->name }}</td>
            <td>{{ Str::limit($serie->desc, 100) }}</td>
            <td>{{ $serie->actor }}</td>
            <td>{{ $serie->director }}</td>
            <td><a href="{{ $serie->video_url }}" target="_blank">Ver Video</a></td>
            <td>{{ $serie->num_episode }}</td>
            <td>
                <div class="d-flex gap-2">
                    <a href="{{ route('series.edit', $serie->id) }}" class="btn btn-primary">Editar Serie</a>
                    <a href="{{ route('admin.episodesPanel', $serie->id) }}" class="btn btn-info">Ver Episodios</a>
                    <form action="{{ route('series.destroy', $serie->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta serie?')">Eliminar Serie</button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
</tbody>

    </table>
</header>
@endsection
