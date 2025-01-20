<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Custom CSS -->
        <style>
            body {
                margin: 0;
                padding: 0;
                min-height: 100vh;
                background-color: #fff;
                overflow-x: hidden;
            }
            .container-fluid {
                padding: 0;
                min-height: 100vh;
                display: flex;
            }
            .left-content {
                width: 50%;
                position: relative;
                z-index: 2;
                background: white;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                padding: 50px;
            }
            .right-content {
                width: 55%;
                background-image: url('{{ asset('asset/image/amaliahb.jpg') }}');
                background-size: cover;
                background-position: center;
                clip-path: polygon(25% 0, 100% 0, 100% 100%, 0 100%);
            }
            .right-content::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(
                rgba(0, 0, 0, 0.6),
                rgba(0, 0, 0, 0.8)
            );
            }
            .logo-container {
                position: fixed;
                top: 35px;
                left: 0px;
                background: rgb(255, 255, 255);
                padding: 10px 25px;
                border-radius: 0 20px 20px 0;
                display: flex;
                align-items: center;
                gap: 10px;
                z-index: 1000;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            .logo {
                height: 35px;
                object-fit: contain;
            }
            .login-form-container {
                width: 100%;
                padding: 0 50px;
            }
            .login-form {
                width: 100%;
                max-width: 550px; /* Form diperlebar */
                padding: 20px 30px; /* Padding tambahan untuk jarak dalam form */
                border-radius: 8px;
            }
            .btn-login {
                background-color: #7bc043;
                border: none;
                padding: 8px 30px;
                border-radius: 20px;
                color: white;
                font-weight: 500;
                font-size: 14px;
                margin-top: 15px;
            }
            .back-link {
                color: #666;
                text-decoration: none;
                font-size: 12px;
                display: block;
                margin-top: 12px;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="logo-container">
                <img src="{{ asset('asset/image/legepeges.png') }}" alt="Logo 1" class="logo">
                <img src="{{ asset('asset/image/logosmk-wide.png') }}" alt="Logo 2" class="logo">
            </div>
            {{ $slot }}
        </div>

        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
