<!doctype html>
<html lang="en">
<head>
    <title>@yield('title', 'Default Title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('template/css/style.css') }}">
</head>
<body>
    <div class="wrapper d-flex align-items-stretch">
        
        <!-- Include Sidebar -->
        @include('sidebar')

        <!-- Page Content -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <!-- Header -->
            <div class="d-flex justify-content-end align-items-center mb-4">
                <!-- Tombol Logout -->
                <form method="POST" action="{{ route('logout') }}" class="d-flex align-items-center">
                    @csrf
                    <button type="submit" class="btn btn-light border d-flex align-items-center">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </div>

            @yield('content')
        </div>
    </div>

    <script src="{{ asset('template/js/jquery.min.js') }}"></script>
    <script src="{{ asset('template/js/popper.js') }}"></script>
    <script src="{{ asset('template/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template/js/main.js') }}"></script>
</body>
</html>
