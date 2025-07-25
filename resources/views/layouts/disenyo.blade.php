<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <style>
                   
        </style>
      

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <title>{{ config('app.name', 'Laravel') }}</title>
        <body class="font-sans antialiased">
        <main class="container">
            
        <nav class="navbar bg-secondary  border-bottom border-body navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
            <div class="container-fluid">
                <img src="image/logo.jpeg" alt="Logo" height="36">PiFlix</img>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/films">Film</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/series">Series</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/favourite">Favourite</a>
                        </li>
                        <li>
                            <a class="nav-link" href="/recomends">Recommended</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Profile
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Setting</a></li>
                                <li><a class="dropdown-item" href="/subs">Subscription</a></li>
                                <li><a class="dropdown-item" href="/admin/panel">Admin</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/logout">Logout</a></li>
                            </ul>
                        </li>

                    </ul>
                    <form class="d-flex" role="search" action="{{ route('home') }}" method="GET">
                        <input class="form-control me-2" type="search" name="search" placeholder="Search movies or series" aria-label="Search" value="{{ request('search') }}">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>

          @yield('content')

          <footer class="bg-body-tertiary text-center">
            <!-- Grid container -->
            <div class="container p-4"></div>
             <!-- Grid container -->

            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                © 2025 Copyright:
                <a class="text-body" href="https://mdbootstrap.com/">PiFlix</a>
            </div>
            <!-- Copyright -->
          </footer>
        </main>
          <!-- Bootstrap JS (incluye Popper.js necesario para algunos componentes como el carrusel) -->
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
