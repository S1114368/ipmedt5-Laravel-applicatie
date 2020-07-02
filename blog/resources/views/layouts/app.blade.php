<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/main.min.js') }}" defer></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/main.min.css') }}" rel="stylesheet">
</head>
<body>
    @if((Route::current()->getName() !== 'login') && (Route::current()->getName() !== 'register'))
  <nav class="navbar">
    <div class="navbarDesktop">
        <a class="navLeft"href="/home" class="active">Dashboard</a>
        <a class="navLeft"href="/home/grocerylist">Grocery list</a>
        <a class="navLeft"href="/home/overzicht">My items</a>
        <a class="navRight"href="/home/logout">Log out</a>
        <!-- als de gebruiker de rol admin heeft zal de admin navigatie worden weergegeven -->
        @if(Auth::user()->role == "admin")
        <a class="navRight"href="/home/admin">Admin</a>
        @else
        @endif
      </a>
    </div>
    <ul id="js--navbar" class="navbar__list">
      <li id="js--barContainer" class="navbar__list__item--right bar-container">
        <div id="js--firstBar" class="bar-container__bar--1"></div>
        <div id="js--secondBar" class="bar-container__bar--2"></div>
        <div id="js--thirdBar" class="bar-container__bar--3"></div>
      </li>
    </ul>

      <div id="js--mobileNav" class="menu-pages-container hide-nav">
        <ul id="menu-pages" class="menu-header">
          <li id="menu-item-1" class="menu-item ">
            <a href="/home">Dashboard</a>
          </li>
          <li id="menu-item-2" class="menu-item ">
            <a href="/home/grocerylist">Grocery list</a>
          </li>
          <li id="menu-item-3" class="menu-item ">
            <a href="/home/overzicht">My items</a>
          </li>
          <!-- als de gebruiker de rol admin heeft zal de admin navigatie worden weergegeven -->
          @if(Auth::user()->role == "admin")
          <li id="menu-item-4" class="menu-item ">
            <a href="/home/admin">Admin</a>
          </li>
          @else
          @endif
          <li id="menu-item-5" class="menu-item ">
            <a href="/home/logout">Log out</a>
          </li>
        </ul>
      </div>
    </nav>
@endif
    <div id="app">


        <main class="py-4">
            @yield('content')

        </main>
    </div>
</body>
</html>
