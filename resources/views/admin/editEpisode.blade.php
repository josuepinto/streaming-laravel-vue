@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">✏️ Editar Episodio</h1>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Errores de validación --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario de edición --}}
    <form action="{{ route('episodes.update', $episode->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Título --}}
        <div class="form-group mb-3">
            <label for="title">Título del Episodio:</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $episode->title) }}" required>
        </div>

        {{-- URL del Video --}}
        <div class="form-group mb-3">
            <label for="video_url">URL del Video:</label>
            <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $episode->video_url) }}" required>
        </div>

        {{-- Imagen actual si existe --}}
        @if($episode->image)
            <div class="mb-3">
                <label>Imagen actual:</label><br>
                <img src="{{ asset('storage/' . $episode->image) }}" alt="Imagen actual" style="width: 200px; object-fit: cover;" class="img-thumbnail">
            </div>
        @endif

        {{-- Cargar nueva imagen --}}
        <div class="form-group mb-4">
            <label for="image">Nueva Imagen (opcional):</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        {{-- Botón de actualizar --}}
        <button type="submit" class="btn btn-success w-100">Guardar Cambios</button>
    </form>
</div>
@endsection
