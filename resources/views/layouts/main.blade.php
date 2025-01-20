<!doctype html>
<html lang="en">
<head>
    <title>@yield('title', 'Default Title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('template/css/style.css') }}">
</head>
<body>
    <div class="wrapper d-flex align-items-stretch">
        
        <!-- Include Sidebar -->
        @include('sidebar')

        <!-- Page Content -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <!-- Yield Content -->
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('template/js/jquery.min.js') }}"></script>
    <script src="{{ asset('template/js/popper.js') }}"></script>
    <script src="{{ asset('template/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template/js/main.js') }}"></script>
</body>
</html>
