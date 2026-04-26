<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>{{ config('app.name', 'PiFlix') }}</title>
</head>
<body class="stream-app">
    <div class="stream-shell">
        <header class="stream-header">
            <nav class="navbar navbar-expand-lg stream-navbar">
                <div class="container-fluid stream-navbar-inner">
                    <a href="{{ route('home') }}" class="stream-brand">
                        <span class="stream-brand-mark">PI</span>
                        <span class="stream-brand-text">PiFlix</span>
                    </a>

                    <button class="navbar-toggler stream-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#streamNavbar" aria-controls="streamNavbar" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="streamNavbar">
                        <ul class="navbar-nav stream-nav-links me-auto">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('films') ? 'active' : '' }}" href="{{ route('movieList') }}">Movies</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('series') || request()->is('seriesList/*') ? 'active' : '' }}" href="{{ route('listaSeries') }}">Series</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('favourite') ? 'active' : '' }}" href="{{ route('favourite.index') }}">My List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('recomends') ? 'active' : '' }}" href="{{ route('recomends') }}">Recommended</a>
                            </li>
                        </ul>

                        <div class="stream-header-actions">
                            <form class="stream-search" action="{{ route('home') }}" method="GET">
                                <input
                                    class="form-control stream-search-input"
                                    type="search"
                                    name="search"
                                    placeholder="Search movies or series"
                                    value="{{ request('search') }}"
                                >
                                <button class="btn stream-search-btn" type="submit">Search</button>
                            </form>

                            <div class="dropdown">
                                <button class="btn stream-profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Profile
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end stream-dropdown">
                                    <li><a class="dropdown-item" href="{{ url('/subs') }}">Subscription</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/admin/panel') }}">Admin</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <main class="stream-main">
            @yield('content')
        </main>

        <footer class="stream-footer">
            <div class="stream-footer-inner">
                <p class="mb-1">PiFlix</p>
                <p class="mb-0">Laravel 9 · Blade · Streaming-inspired portfolio build</p>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
