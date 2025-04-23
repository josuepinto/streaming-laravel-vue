@extends('layouts.admin')

@section('content')
<header class="banner mt-5 text-center">
    <h1>Añadir Nueva Serie</h1>
</header>

<form method="POST" action="{{ route('series.store') }}" class="container mt-5" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Nombre de la Serie:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="desc">Descripción:</label>
                <textarea id="desc" name="desc" class="form-control" required></textarea>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="actor">Actores:</label>
                <input type="text" id="actor" name="actor" class="form-control" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="director">Director:</label>
                <input type="text" id="director" name="director" class="form-control" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="image">Imagen de la Serie:</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="video_url">URL del Video:</label>
                <input type="url" id="video_url" name="video_url" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="num_episode">Numero de capitulos:</label>
                <input type="number" id="num_episode" name="num_episode" class="form-control" required>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Guardar Serie</button>
</form>
@endsection
