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
            padding-top: 56px; /* Height of the fixed navbar */
            margin: 0;
        }

        main {
            padding: 20px;
            margin: 10% auto; /* Center content horizontally */
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

        .buttons {
            margin-top: 20px;
            text-align: center;
        }

        .buttons a {
            margin-right: 10px;
        }

        .content {
            text-align: center; /* Center the text and icon */
        }

        .content img {
            margin-bottom: 20px; /* Add some space below the icon */
        }

        body {
            padding-top: 56px;
            margin: 0;
            background-color: #fcd8b6; 

        }
        
        .btn-primary {
            background-color: #fb8239;
            border-color: #fb8239;
        }

        .card {
            background-color: #a51200;
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
    </style>
</head>
<body>

<header>

</header>

<main>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <img src="{{ asset('public/img/people-roof-solid.svg') }}" alt="SVG image" width="100" height="100">
            <div class="title m-b-md">
                BUSINESS INSIGHTS ACCESS METRICS (AM) SYSTEM
            </div>
            <div class="buttons">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login</a>
                <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">Register</a>
            </div>
        </div>
    </div>

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