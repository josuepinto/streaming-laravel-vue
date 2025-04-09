@extends('layouts.admin')
@section('content')
<header class="banner mt-5">
    <h1>Welcome to the Admin Panel of PiFlix!</h1>
    <br/>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Title</th>
                <th scope="col">Desc</th>
                <th scope="col">Actor</th>
                <th scope="col">Director</th>
                <th scope="col">Genre</th>
                <th scope="col">Year</th>
                <th scope="col">Video_url</th>
                <th scope="col">Admin Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($movies as $movie)
            <tr>
                <th scope="row"><img src="{{ asset($movie->image) }}" class="img-fluid img-thumbnail" alt="{{ $movie->title }}"></th>
                <td>{{ $movie->title }}</td>
                <td>{{ $movie->description }}</td>
                <td>{{ $movie->actor }}</td>
                <td>{{ $movie->director }}</td>
                <td>{{ $movie->genre }}</td>
                <td>{{ $movie->year }}</td>
                <td>{{ $movie->video_url }}</td>
                <td>
                    <div class="d-flex gap-2">
                        <form action="{{ route('editMovie', $movie->id) }}" method="GET">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form> 
                        <button type="button" class="btn btn-danger">Delete</button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</header>
@endsection