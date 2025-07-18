@extends('layouts.disenyo')
@section('content')

 <div class="tv-screen mt-4">
    <h1>Watch whatever you like</h1>
    <h6><strong>Title:</strong> {{ $movie->title }}</h6>
  
    <div class="ratio ratio-16x9">
        <iframe src="{{ $movie->video_url }}" allowfullscreen></iframe>
    </div>

       <!-- <div class="video-container"> -->
            <!-- Use the embed link instead of watch link -->
        <!--    <iframe width="560" height="315" src="{{ $movie->video_url }}" frameborder="0" allowfullscreen></iframe>
        </div> -->
 </div>

    <!-- Title and description outside of the .tv-screen div -->
    <div class="movie-info mt-4">
        <p><strong>Description:</strong> {{ $movie->description }}</p>
        <p><strong>Actor:</strong> {{ $movie->actor }}</p>
        <p><strong>Director:</strong> {{ $movie->director }}</p>
        <p><strong>Year:</strong> {{ $movie->year }}</p>
    </div>
 
@endsection