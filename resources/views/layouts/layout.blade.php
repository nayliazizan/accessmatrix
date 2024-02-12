<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>AM system</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('public/img/1790670_access_key_lock_safe_safety_icon.svg') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        body {
            padding-top: 56px;
            margin: 0;
            background-color: #fcd8b6; 

        }

        main {
            padding: 20px;
            margin: 2% auto; 
            width: 80%; 
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa; 
        }
        
        .highlight {
            background-color: rgba(255, 255, 0, 0.5); 
        }

        .btn-primary {
            background-color: #fb8239;
            border-color: #fb8239;
        }

        .card {
            background-color: #a51200;
        }

        .card-header {
            background-color: #F4976C;
            color: white;
        }

        .table thead th {
            background: #a51200 !important;
            color: white !important;
        }

        .form-group {
            color: white;
        }

        div.card-header {
            background: #ffac6e !important;
            
        }

        .card {
            background-color: #a51200;
            border: 7px solid #450b00;
            
        }

        .highlight {
            background-color: #ffff99;
            transition: background-color 0.5s ease;
        }

        #loader{
            position: fixed;
            width: 100%;
            height: 100vh;
            background: #21242d url('{{ asset('public/img/giphy.gif') }}') no-repeat center center;
            z-index: 1;
            overflow: visible;
        }

    </style>
</head>
<body>

<header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="{{ route('dashboard') }}">AM system</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="{{ route('licenses.index') }}">LICENSES<span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="{{ route('projects.index') }}">PROJECTS</a>
                <a class="nav-item nav-link" href="{{ route('groups.index') }}">GROUPS</a>
                <a class="nav-item nav-link" href="{{ route('staffs.index') }}">STAFF</a>
                <a class="nav-item nav-link" href="{{ route('tracker.form') }}">TRACKER</a>
                <!-- Add the logout form here -->
                <form method="POST" action="{{ route('logout') }}" class="nav-item">
                    @csrf
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="nav-link">
                        {{ __('SIGN OUT') }}
                    </x-dropdown-link>
                </form>

            </div>
        </div>
    </nav>
</header>

<div id="loader"></div>

<main>
    <div id="content">@yield('content')</div>
</main>

<footer>
    <p>Copyright 2023 Access Matrix System</p>
</footer>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- In the bottom of index.blade.php, after including Bootstrap JS -->
<script>
    // Close the Export List Modal when the Export Format Modal is shown
    $('#exportFormatModal').on('show.bs.modal', function () {
        $('#exportListModal').modal('hide');
    });
</script>

<script type="text/javascript">

    var loader;
    function loadNow(opacity) {
        if(opacity <= 0) {
            displayContent();
        } else {
            loader.style.opacity = opacity;
            window.setTimeout(function() {
                loadNow(opacity - 0.05);  // Add a semicolon here
            }, 100);
        }
    }

    function displayContent() {
        loader.style.display = 'none';
        content.style.display = 'block';
    }

    document.addEventListener("DOMContentLoaded", function() {
        loader = document.getElementById('loader');
        content = document.getElementById('content');
        loadNow(1);
    });

</script>


</body>
</html>
