@extends('layouts.disenyo')

@section('content')
<div class="content mt-4">
    <h1 class="text-center mb-4">Series List</h1>
    
    <div class="row">
        @foreach($seriesList as $serie)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset($serie->image) }}" class="card-img-top" alt="Berlin">
                <div class="card-body">
                    <h2 class="card-title">{{ $serie->name }}</h2>
                    <p class="card-text">{{ $serie->desc }}</p>
                    <p class="card-text"><strong>Actors:</strong> {{ $serie->actor }}</p>
                    <p class="card-text"><strong>Director:</strong> {{ $serie->director }}</p>
                    <a href="{{$serie->video_url}}" class="btn btn-primary">Watch Now</a>
                </div>
            </div>
        </div>
        @endforeach

    </div>
  
    <!-- Botones para añadir nueva serie y nuevo episodio -->
    <div class="text-center mt-4">
        <a href="/series" class="btn btn-info">Añadir Nueva Serie</a>
        <a href="{{ route('episodes.create') }}" class="btn btn-warning">Añadir Episodio a una Serie</a>
    </div>

</div>
@endsection
