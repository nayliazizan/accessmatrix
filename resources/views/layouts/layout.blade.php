<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>AM system</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        body {
            padding-top: 56px; /* Height of the fixed navbar */
            margin: 0;
        }

        main {
            padding: 20px;
            margin: 2% auto; /* Center content horizontally */
            width: 80%; /* Take 80% of the page width */
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa; /* Use a light background color for the footer */
        }
        
        .highlight {
            background-color: rgba(255, 255, 0, 0.5); /* Yellowish background with 50% opacity */
        }
    </style>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="/dashboard">AM system</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="/licenses">LICENSES<span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="/projects">PROJECTS</a>
                <a class="nav-item nav-link" href="/groups">GROUPS</a>
                <a class="nav-item nav-link" href="/staffs">STAFF</a>
                <a class="nav-item nav-link" href="/tracker/form">TRACKER</a>
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

<main>
    @yield('content')
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

</body>
</html>
