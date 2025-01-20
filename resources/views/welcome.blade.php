<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="asset/style/home.css">
</head>
<body>
<title>home</title>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="nav-buttons">
    </div>
  </nav>

  <!-- Hero Section -->
   <div class="logo-am">
          <img src="img/lps-removebg-preview.png" alt="" class="logo">
      <img src="img/logo_smk_amaliah-removebg-preview.png" alt="" class="logo">
   </div>
  <section class="hero">
    <!-- Text Section -->
    <div class="hero-text">
      <h2>Hallo, Selamat datang di BMS</h2>
      <h1>AYO<br> MENABUNG</h1>
      <p>Isi apaa yaa</p>
      <div class="hero-buttons">
        <a href="{{ route('login') }}"><button class="hero-btn primary">Login</button></a>
      </div>
    </div>

    <!-- Image Section -->
    <div class="hero-image">
      <img src="img/hero.png" alt="">
    </div>
  </section>

  <style>
    body {
      margin: 0;
      font-family: 'Times New Roman', Times, serif;
      background: linear-gradient(to right, #ffffff 40%, #c4edc2 80%);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }


    .hero {
      display: flex;
      flex-direction: column-reverse;
      align-items: center;
      justify-content: center;
      flex: 1;
      gap: 20px;
    }

    .hero-text {
      text-align: center;
    }

    .logo-am{
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo{
      height: 75px;
    }

    .hero-text h1 {
      font-size: 2.5rem;
      font-weight: bold;
      color: #22c55e;
      margin: 10px 0;
      margin-left:80px;
      margin-top: 15px;
    }


    .hero-text h2 {
      font-size: 1.25rem;
      color: #333;
      margin-left:80px;
    }

    .hero-text p {
      font-size: 1rem;
      color: #555;
      margin-bottom: 30px;
      margin-left:81px;
    }

    .hero-buttons .hero-btn {
      padding: 12px 24px;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .hero-buttons .primary {
      background-color: #22c55e;
      color: white;
      border: none;
      margin-left:80px;
    }

    .hero-buttons .primary:hover {
      background-color: #818783;
    }

    .hero-buttons .secondary {
      background-color: white;
      color: #22c55e;
      border: 2px solid #22c55e;
    }

    .hero-buttons .secondary:hover {
      background-color: #c6c4c4;
    }

    .hero-image img {
      max-width: 100%;
      height: auto;
    }

    @media (min-width: 768px) {
      .hero {
        flex-direction: row;
        justify-content: space-between;
      }

      .hero-text {
        text-align: left;
      }
    }
    /* .container{
      display:flex;
      align-items: center;
      justify-content: center;
      gap: 10px ;
    } */
  </style>
</body>
</html>