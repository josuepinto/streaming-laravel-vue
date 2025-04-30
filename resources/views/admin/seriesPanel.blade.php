@extends('layouts.admin')

@section('content')
<header class="banner mt-5">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h1 class="mb-4">Admin Panel - Series</h1>

    {{-- 🔍 Buscador de series --}}
    <form method="GET" action="{{ route('admin.seriesPanel') }}" class="mb-4 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Buscar serie por nombre..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Buscar</button>
        @if(request('search'))
            <a href="{{ route('admin.seriesPanel') }}" class="btn btn-secondary ms-2">Limpiar</a>
        @endif
    </form>

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
            @forelse($seriesList as $serie)
                <tr>
                    <td>
                    <img src="{{ asset('storage/' . $serie->image) }}"
     alt="{{ $serie->name }}"
     class="img-thumbnail object-fit-cover w-100"
     style="height: 250px;  max-width: 350px;">

                    </td>
                    <td>{{ $serie->name }}</td>
                    <td>{{ Str::limit($serie->desc, 100) }}</td>
                    <td>{{ $serie->actor }}</td>
                    <td>{{ $serie->director }}</td>
                    <td><a href="{{ $serie->video_url }}" target="_blank">Ver Video</a></td>
                    <td>{{ $serie->num_episode }}</td>
                    <td>
                        <div class="d-flex flex-column gap-1">
                            <a href="{{ route('series.edit', $serie->id) }}" class="btn btn-sm btn-primary">Editar Serie</a>
                            <a href="{{ route('admin.episodesPanel', $serie->id) }}" class="btn btn-sm btn-info">Ver Episodios</a>
                            <form action="{{ route('series.destroy', $serie->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta serie?')">
                                    Eliminar Serie
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No se encontraron series.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</header>
@endsection
