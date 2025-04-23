<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <title>{{ config('app.name', 'Laravel') }}</title>
        <body class="font-sans antialiased">
        <div class="jumbotron text-center">
            <h1>PiFlix</h1>
        </div>
        <main class="container">
            
        <nav class="navbar bg-secondary  border-bottom border-body navbar-expand-lg bg-body-tertiary" data-bs-theme="light">
            <div class="container-fluid">
                <img src="image/logo.jpeg" width="30" height="30" alt="">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/admin/panel">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/addMovie">Add New Film</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/create">Add New Episode</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/addSerie">Add New Serie</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/home">Home User</a>
                        </li>
                     
                    </ul>
                  
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

    </body>
</html>