@extends('layouts.disenyo')
@section('content')
<div class="content mt-4">
    <!-- by default here we show action movies as a recommended 
     if for example we donot have any movie in action then we get the nothing msg -->
    <h1 class="text-center mb-4">Recommended</h1>
    @if ($actionMovies->isEmpty())
        <div class="text-center">
            <h4>No movies in recommended list.</h4>
        </div>
    @else        
        <div class="row">                                
            @foreach($actionMovies as $movie)
                <div class="col-md-4 mb-4">                                                        
                    <div class="card h-100">                                                        
                        <img src="{{ asset($movie->image) }}" class="card-img-top" alt="MovieImage">                                                        
                        <div class="card-body">                                                        
                            <h5>{{ $movie->title }}</h5>                                                        
                            <p>{{ $movie->description }}</p>                                                        
                            <a href="{{ route('watch', $movie->id) }}" class="btn btn-primary">Watch Now</a>                                                        
                        </div>                                                        
                    </div>                                                        
                </div>                                                        
            @endforeach                                                        
        </div>                                                        
    @endif
</div>  
@endsection