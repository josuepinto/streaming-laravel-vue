@extends('layouts.admin')
@section('content')
<form method="POST">
<header class="banner mt-5">
    <h1>Add Movie to the List</h1>
</header>
  <div class="mb-3">
    <label for="title" class="form-label">Movie Name:</label>
    <input type="text" class="form-control" id="title">
  </div>
  <div class="mb-3">
    <label for="description" class="form-label">Description:</label>
    <input type="text" class="form-control" id="description">
  </div>
  <div class="mb-3">
    <label for="genre" class="form-label">Genre:</label>
    <input type="text" class="form-control" id="genre">
  </div>
  <div class="mb-3">
    <label for="year" class="form-label">Year:</label>
    <input type="text" class="form-control" id="year">
  </div>
  <div class="mb-3">
    <label for="video_url" class="form-label">Video_url:</label>
    <input type="text" class="form-control" id="video_url">
  </div>
  <div class="mb-3">
    <label for="image" class="form-label">Image:</label>
    <input type="file" class="form-control" id="image">
  </div>
  
  <button type="submit"  class="btn btn-primary">Add Movie</button>
</form>
@endsection