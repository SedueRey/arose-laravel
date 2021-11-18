<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Arose project') }}</title>

    <!-- Scripts -->
    @yield('script')
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="dns-prefetch" href="//kit.fontawesome.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @if(Route::current()->getName() == 'chat')
    <script>
        window.conversations = {!! isset($conversations) ? json_encode($conversations) : '' !!};
        window.participant = {!! isset($participant) ? json_encode($participant) : '' !!};
    </script>
    <script>
        var user = {!! json_encode((array)auth()->user()) !!};
        var isAdmin = {{ auth()->user()->isadmin }};
    </script>
    @endif
    <script src="https://kit.fontawesome.com/353383640a.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="app">
        @include('header')
        <main class="container py-4">
            @yield('content')
        </main>
    </div>
    <div class="container">
    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
          <div class="col-12 col-md">
            <img class="mb-2" title="Arose project logo" alt="Arose project logo" src="/assets/arose/logo.png" />
            <small class="d-block mb-3 text-muted">© 2021</small>
          </div>
          <div class="col-12 col-md">
            <h5>About Arose Project</h5>
            <ul class="list-unstyled text-small">
              <li><a class="text-muted" href="https://www.um.es/aroseproject/objetives/">Objectives</a></li>
              <li><a class="text-muted" href="https://www.um.es/aroseproject/partners/">Partners</a></li>
              <li><a class="text-muted" href="https://www.um.es/aroseproject/contact/">Contact</a></li>
            </ul>
          </div>
        </div>
        <div class="row">
            <div class="col-md-7 offset-md-3 ml-md-auto">
                <p class="mt-5 text-xs-small text-muted font-weight-light">This project has been funded with support from the European Commission. This webpage reflects the views only of the author, and the Commission cannot be held responsible for any use which may be made of the information contained therein. Project Erasmus+ AROSE (2019-1-ES01-KA201-065597)</p>
            </div>
        </div>
      </footer>
</div>
</body>
</html>
