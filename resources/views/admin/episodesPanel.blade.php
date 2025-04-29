@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Episodios de la Serie: <strong>{{ $serie->name }}</strong></h1>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Botón para agregar un nuevo episodio directamente para esta serie --}}
    <div class="mb-3 text-end">
        <form method="POST" action="{{ route('addEpisode') }}">
            @csrf
            <input type="hidden" name="serie_id" value="{{ $serie->id }}">
            <button type="submit" class="btn btn-success">➕ Añadir nuevo episodio a esta serie</button>
        </form>
    </div>

    {{-- Tabla de episodios --}}
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Imagen</th>
                <th>Título</th>
                <th>Temporada</th>
                <th>Episodio</th>
                <th>Video URL</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($episodes as $episode)
                <tr>
                    <td>
                        @if($episode->image)
                            <img src="{{ asset('storage/' . $episode->image) }}" alt="Banner" width="120" height="70" style="object-fit: cover;">
                        @else
                            Sin imagen
                        @endif
                    </td>
                    <td>{{ $episode->title }}</td>
                    <td>{{ $episode->season }}</td>
                    <td>{{ $episode->episode_number }}</td>
                    <td><a href="{{ $episode->video_url }}" target="_blank">Ver video</a></td>
                    <td class="d-flex gap-2">
                        {{-- Editar episodio --}}
                        <a href="{{ route('episodes.edit', $episode->id) }}" class="btn btn-primary btn-sm">✏️ Editar</a>

                        {{-- Eliminar episodio --}}
                        <form method="POST" action="{{ route('episodes.destroy', $episode->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este episodio?')">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay episodios registrados para esta serie.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
