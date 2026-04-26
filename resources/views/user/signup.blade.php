@extends('layouts.user')

@section('content')
<div class="auth-card auth-card-register">
    <div class="auth-logo">PI</div>

    <div class="auth-header">
        <span class="auth-kicker">Join PiFlix</span>
        <h1 class="auth-title">Create your account</h1>
        <p class="auth-subtitle">
            Register to access your streaming catalogue, personal favourites and demo platform features.
        </p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger auth-alert" role="alert">
            Please review the form fields and correct the highlighted errors.
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="auth-form" novalidate>
        @csrf

        <div class="auth-form-group">
            <label for="name" class="auth-label">Full name</label>
            <input
                type="text"
                class="form-control auth-input @error('name') is-invalid @enderror"
                id="name"
                name="name"
                value="{{ old('name') }}"
                placeholder="Enter your full name"
                autocomplete="name"
            >
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

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
                placeholder="Minimum 8 characters"
                autocomplete="new-password"
            >
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-form-group">
            <label for="password_confirmation" class="auth-label">Confirm password</label>
            <input
                type="password"
                class="form-control auth-input"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="Repeat your password"
                autocomplete="new-password"
            >
        </div>

        <button type="submit" class="btn auth-button auth-button-primary">
            Create account
        </button>
    </form>

    <div class="auth-divider"></div>

    <div class="auth-footer-box">
        <p class="auth-footer-text">Already have an account?</p>
        <a href="{{ route('login') }}" class="btn auth-button auth-button-secondary">
            Log in
        </a>
    </div>
</div>
@endsection
