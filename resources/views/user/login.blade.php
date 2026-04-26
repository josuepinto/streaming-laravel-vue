@extends('layouts.user')

@section('content')
<div class="auth-card auth-card-login">
    <div class="auth-logo">PI</div>

    <div class="auth-header">
        <span class="auth-kicker">Welcome Back</span>
        <h1 class="auth-title">Sign in to your streaming space</h1>
        <p class="auth-subtitle">
            Continue exploring your catalogue, favourites and admin-ready portfolio experience.
        </p>
    </div>

    @if (session('error'))
        <div class="alert alert-danger auth-alert" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success auth-alert" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->has('login'))
        <div class="alert alert-danger auth-alert" role="alert">
            {{ $errors->first('login') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form" novalidate>
        @csrf

        <div class="auth-form-group">
            <label for="email" class="auth-label">Email address</label>
            <input
                type="email"
                class="form-control auth-input @error('email') is-invalid @enderror"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="name@example.com"
                autocomplete="email"
            >
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-form-group">
            <label for="password" class="auth-label">Password</label>
            <input
                type="password"
                class="form-control auth-input @error('password') is-invalid @enderror"
                id="password"
                name="password"
                placeholder="Enter your password"
                autocomplete="current-password"
            >
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn auth-button auth-button-primary">
            Log in
        </button>
    </form>

    <div class="auth-divider"></div>

    <div class="auth-footer-box">
        <p class="auth-footer-text">Don’t have an account yet?</p>
        <a href="{{ route('inici') }}" class="btn auth-button auth-button-secondary">
            Create account
        </a>
    </div>
</div>
@endsection
