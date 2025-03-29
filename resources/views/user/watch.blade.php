@extends('layouts.disenyo')
@section('content')

 <div class="tv-screen mt-4">
    <h1>Watch whatever you like</h1>
    <h6>Title: {{ $movie->title }}</h6>
        <div class="video-container">
            <!-- Use the embed link instead of watch link -->
            <iframe width="560" height="315" src="{{ $movie->video_url }}" frameborder="0" allowfullscreen></iframe>
        </div>
 </div>

    <!-- Title and description outside of the .tv-screen div -->
    <div class="movie-info mt-4">
        <p>Description: {{ $movie->description }}</p>
        <p>Actor: {{ $movie->actor }}</p>
        <p>Director: {{ $movie->director }}</p>
    </div>
@endsection