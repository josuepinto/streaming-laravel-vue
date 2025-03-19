@extends('layouts.admin')
@section('content')
<form>
<header class="banner mt-5">
    <h1>Add Movie to the List</h1>
</header>
  <div class="mb-3">
    <label for="name" class="form-label">Movie Name:</label>
    <input type="text" class="form-control" id="name">
  </div>
  <div class="mb-3">
    <label for="desc" class="form-label">Description:</label>
    <input type="text" class="form-control" id="desc">
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
  <div class="mb-3">
    <label for="actor" class="form-label">Actor</label>
    <input type="text" class="form-control" id="actor">
  </div>
  <div class="mb-3">
    <label for="director" class="form-label">Director</label>
    <input type="text" class="form-control" id="director">
  </div>
  <button type="submit"  class="btn btn-primary">Add Movie</button>
</form>
@endsection