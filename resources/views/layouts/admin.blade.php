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

    <title>{{ config('app.name', 'PiFlix') }} Admin</title>
</head>
<body class="stream-app admin-app">
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a href="{{ route('adminPanel') }}" class="admin-brand">
                <span class="admin-brand-mark">PI</span>
                <div>
                    <span class="admin-brand-title">PiFlix</span>
                    <span class="admin-brand-subtitle">Admin Panel</span>
                </div>
            </a>

            <nav class="admin-nav">
                <a class="admin-nav-link {{ request()->routeIs('adminPanel') ? 'active' : '' }}" href="{{ route('adminPanel') }}">
                    Movies
                </a>
                <a class="admin-nav-link {{ request()->routeIs('addMovie') ? 'active' : '' }}" href="{{ route('addMovie') }}">
                    Add Movie
                </a>
                <a class="admin-nav-link {{ request()->routeIs('series.create') ? 'active' : '' }}" href="{{ route('series.create') }}">
                    Add Series
                </a>
                <a class="admin-nav-link {{ request()->routeIs('admin.seriesPanel') ? 'active' : '' }}" href="{{ route('admin.seriesPanel') }}">
                    Series Panel
                </a>
                <a class="admin-nav-link {{ request()->routeIs('addEpisode') ? 'active' : '' }}" href="{{ route('addEpisode') }}">
                    Add Episode
                </a>
                <a class="admin-nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                    Back To App
                </a>
            </nav>
        </aside>

        <div class="admin-main-shell">
            <header class="admin-topbar">
                <div>
                    <span class="admin-kicker">Dashboard</span>
                    <h1 class="admin-topbar-title">
                        @yield('admin_title', 'Manage your PiFlix catalogue')
                    </h1>
                </div>

                <div class="admin-topbar-actions">
                    <a href="{{ route('home') }}" class="btn poster-btn poster-btn-secondary">User View</a>
                    <a href="{{ route('logout') }}" class="btn poster-btn poster-btn-danger">Logout</a>
                </div>
            </header>

            <main class="admin-main-content">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
