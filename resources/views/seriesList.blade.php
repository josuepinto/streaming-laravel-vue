@extends('layouts.disenyo')

@section('content')
<div class="content mt-4">
    <h1 class="text-center mb-4">Series List</h1>
    
    <div class="row">
    @foreach($seriesList as $serie)
<div class="col-md-4 mb-4">
    <div class="card">
        <img src="{{ asset($serie->image) }}" class="card-img-top" alt="{{ $serie->name }}">
        <div class="card-body">
            <h2 class="card-title">{{ $serie->name }}</h2>
            <p class="card-text">{{ $serie->desc }}</p>
            <a href="{{ route('series.show', $serie->id) }}" class="btn btn-primary">Ver Detalles</a>
        </div>
    </div>
</div>
@endforeach

    </div>
  


</div>
@endsection
