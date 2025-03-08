@extends('layouts.disenyo')

@section('content')
<div class="content mt-4">
    <h1 class="text-center mb-4">Series List</h1>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('image/berlin.jpg') }}" class="card-img-top" alt="Berlin">
                <div class="card-body">
                    <h2 class="card-title">Berlin</h2>
                    <p class="card-text">The Energy of Love. During his glory days, Berlin assembles a gang in Paris for an almost impossible heist for 44M €.</p>
                    <p class="card-text"><strong>Actors:</strong> Pedro Alonso, Joel Sanchez, Maria Isabel</p>
                    <p class="card-text"><strong>Director:</strong> Alex Pina</p>
                    <a href="#" class="btn btn-primary">Watch Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('image/squadgame.jpeg') }}" class="card-img-top" alt="squidgame">
                <div class="card-body">
                    <h2 class="card-title">Squid Game</h2>
                    <p class="card-text">It revolves around a secret contest where 456 players, all of whom are in deep financial hardship, risk their lives to play a series of deadly children's games.</p>
                    <p class="card-text"><strong>Actors:</strong> Lee Jung, Park Hae, Kim Joo</p>
                    <p class="card-text"><strong>Director:</strong> Hwang Dong-hyuk</p>
                    <a href="#" class="btn btn-primary">Watch Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
