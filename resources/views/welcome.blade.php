<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WELCOME</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@600;800;900&display=swap');

        body, html {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            height: 100%;
            overflow: hidden;
        }

        .landing-page {
            position: relative;
            width: 100vw;
            height: 100vh;
        }

        .background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
        }

        .background-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                rgba(0, 0, 0, 0.7),
                rgba(0, 0, 0, 0.8)
            );
            z-index: -1;
        }

        .nav-buttons {
            position: absolute;
            top: 2rem;
            right: 2rem;
            display: flex;
            gap: 2rem;
            z-index: 10;
        }

        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            width: 90%;
            max-width: 800px;
            color: white;
            z-index: 1;
        }

        .header-text h1 {
            font-size: 4.5rem;
            font-weight: 900;
            margin: 0;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            animation: fadeInDown 1s ease-out;
        }

        .header-text p {
            font-size: 2.5rem;
            margin: 1rem 0;
            font-weight: 800;
            color: #a5e48b;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            animation: fadeInUp 1s ease-out;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            font-size: 1.3rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            padding: 5px 0;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #a5e48b;
            transition: width 0.3s ease;
        }

        .nav-link:hover {
            color: #a5e48b;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .header-text h1 {
                font-size: 3rem;
            }

            .header-text p {
                font-size: 1.8rem;
            }

            .nav-buttons {
                top: 1rem;
                right: 1rem;
                gap: 1rem;
            }

            .nav-link {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <div class="landing-page">
        <img src="{{ asset('asset/image/amaliahb.jpg') }}" alt="Background" class="background-image">
        <div class="background-overlay"></div>
        <div class="nav-buttons">
            <a href="{{route('login') }}" class="nav-link">Login</a>
        </div>
        <div class="content">
            <div class="header-text">
                <h1> SELAMAT DATANG </h1>
                <p>MINI BANK AMALIAH</p>
            </div>
        </div>
    </div>
</body>
</html>