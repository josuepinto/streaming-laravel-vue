@extends('layouts.user')

@section('content')
<div class="row justify-content-center mt-5">
  <div class="col-md-6">    
    <div class="login-container">
      <h1>Login to PiFLIX</h1>
        <img src="/image/login.jpeg" alt="Logo" width="50%" height="auto"> <br>
        <form method="POST" action="{{ route('login') }}">
          @csrf
            <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Username">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
  </div>
</div>
@endsection