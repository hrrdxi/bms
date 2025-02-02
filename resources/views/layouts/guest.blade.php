<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
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
                position: relative;
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
                clip-path: polygon(20% 0, 100% 0, 100% 100%, 0 100%);
                right: 0;
                top: 0;
                height: 100vh;
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
                rgba(0, 0, 0, 0.7)
            );
            }

            .logo-container {
                position: fixed;
                top: 0px;
                left: 0px;
                background: rgb(255, 255, 255);
                padding: 20px 35px;
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
                max-width: 400px; /* Ukuran form yang lebih kecil */
                padding: 0 20px;
            }

            .login-form {
                width: 100%;
                padding: 20px 0; /* Menghilangkan padding horizontal */
            }

            .form-control {
                border-radius: 8px;
                padding: 10px 15px;
                border: 1px solid #ddd;
            }

            .form-control:focus {
                border-color: #7bc043;
                box-shadow: 0 0 0 0.2rem rgba(123, 192, 67, 0.25);
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
                width: 100%;
            }

            .btn-login:hover {
                background-color: #69a939;
            }

            .back-link {
                color: #666;
                text-decoration: none;
                font-size: 12px;
                display: block;
                margin-top: 12px;
            }

            @media (max-width: 992px) {
                .left-content {
                    width: 100%;
                }

                .right-content {
                    display: none;
                }

                .logo-container {
                    position: absolute;
                    width: 100%;
                    border-radius: 0;
                    justify-content: center;
                }

                .login-form-container {
                    margin-top: 80px;
                }
            }

            @media (max-width: 576px) {
                .login-form-container {
                    padding: 0 15px;
                }

                .logo {
                    height: 25px;
                }
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>