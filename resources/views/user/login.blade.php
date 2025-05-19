@extends('layouts.user')

@section('content')
<div class="row justify-content-center mt-5">
@if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
@endif

@if (session('error'))
      <div class="alert alert-danger">
          {{ session('error') }}
      </div>
@endif

  <div class="col-md-6">
    <div class="login-container">
      <h1>Login to PiFLIX</h1>
        <img src="/image/login.jpeg" alt="Logo" width="50%" height="auto"> <br>
        <form method="POST" action="{{ route('login') }}">
          @csrf
            <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Username">
            </div>
            <br/>
            <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <br />
            <input type="hidden" name="role" value="user"> <!-- Por defecto el rol es user -->
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <div class="mt-3">
            <p>Create account  <a href="/register">Signup here</a></p>
        </div>
    </div>
  </div>
</div>
@endsection
