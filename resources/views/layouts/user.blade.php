<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        

        <!--<link rel="stylesheet" href="/css/app.css'">-->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <title>{{ config('app.name', 'Laravel') }}</title>
    </head>
    <body class="font-sans antialiased">
    <main class="container">
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
        <!--<script src="/js/app.js" defer></script>-->
    </body>
</html>