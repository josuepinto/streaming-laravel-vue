@extends('layouts.admin')
@section('content')
<div class="content">
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
<form method="POST" action="{{ route('store') }}" enctype="multipart/form-data">
<header class="banner mt-5 text-center">
    <h1>Add Movie to the List</h1>
</header>
  @csrf
  <div class="mb-3">
    <label for="title" class="form-label">Movie Name:</label>
    <input type="text" name="title" class="form-control" value="{{ old('title') }}" id="title">
  </div>
  <div class="mb-3">
    <label for="description" class="form-label">Description:</label>
    <input type="text" name="description" class="form-control" value="{{ old('description') }}" id="description">
  </div>
  <div class="mb-3">
    <label for="genre" class="form-label">Genre:</label>
    <input type="text" name="genre" class="form-control" id="genre">
  </div>
  <div class="mb-3">
    <label for="year" class="form-label">Year:</label>
    <input type="text" name="year" class="form-control" id="year">
  </div>
  <div class="mb-3">
    <label for="video_url" class="form-label">Video_url:</label>
    <input type="text" name="video_url" class="form-control" id="video_url">
  </div>
  <div class="mb-3">
    <label for="image" class="form-label">Image:</label>
    <input type="file" name="image" class="form-control" id="image">
  </div>
  
  <button type="submit"  class="btn btn-primary">Add Movie</button>
</form>
</div>
@endsection