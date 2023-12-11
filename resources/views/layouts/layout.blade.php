<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="/css/main.css" rel="stylesheet">
    </head>
    <body>
    <header>
        <div class="logo">
            <img src="img/people-roof-solid.svg" alt="Your Logo">
        </div>
        <!-- Other header content goes here -->
    </header>

      @yield('content')
        
      <footer>
        <p>Copyright 2023 Access Matrix System</p>
      </footer>
    </body>
</html>