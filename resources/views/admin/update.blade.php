@extends('layouts.admin')

@section('content')
<div class="content">
  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif
    <!--Aqui lista los mensajes de error si los hay-->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('updateMovie', $movie->id) }}" enctype="multipart/form-data">
@csrf
@method('PUT')
<header class="banner mt-5 text-center">
    <h1>UPDATE Movie</h1>
</header>
  @csrf
  <div class="mb-3">
    <label for="title" class="form-label">Title:</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $movie->title) }}" id="title">
  </div>
  <div class="mb-3">
    <label for="description" class="form-label">Description:</label>
    <input type="text" name="description" class="form-control" value="{{ old('description', $movie->description) }}" id="description">
  </div>
  <div class="mb-3">
    <label for="actor" class="form-label">Actor:</label>
    <input type="text" name="actor" class="form-control" value="{{ old('actor', $movie->actor) }}" id="actor">
  </div>
  <div class="mb-3">
    <label for="director" class="form-label">Director:</label>
    <input type="text" name="director" class="form-control" value="{{ old('director', $movie->director) }}" id="director">
  </div>
  <div class="mb-3">
    <label for="genre" class="form-label">Genre:</label>
    <input type="text" name="genre" class="form-control" value="{{ old('genre', $movie->genre) }}"  id="genre">
  </div>
  <div class="mb-3">
    <label for="year" class="form-label">Year:</label>
    <input type="text" name="year" class="form-control" value="{{ old('year', $movie->year) }}" id="year">
  </div>
  <div class="mb-3">
    <label for="video_url" class="form-label">Video_url:</label>
    <input type="text" name="video_url" class="form-control" value="{{ old('video_url', $movie->video_url) }}" id="video_url">
  </div>
  <div class="mb-3">
    <label for="image" class="form-label">Image:</label>
    <input type="file" name="image" class="form-control" value="{{ old('image', $movie->image) }}" id="image">
  </div>
  
  <button type="submit"  class="btn btn-primary">Update Movie</button>
</form>
</div>
@endsection
