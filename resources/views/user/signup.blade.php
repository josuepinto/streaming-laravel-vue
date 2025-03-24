@extends('layouts.disenyo')

@section('content')
<div class="row justify-content-center mt-5">
  <div class="col-md-6">
    <div class="sign-container">
        <h2>Sign Up to PiFLIX</h2>
        <img src="/image/signup.png" alt="Logo" width="70" height="50">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
            </div>
            <button type="submit" class="btn btn-primary">Signup</button>
        </form>
        <div class="mt-3">
            <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
        </div>
    </div>
  </div>
</div>
@endsection