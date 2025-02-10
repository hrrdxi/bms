<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            margin: 0;
            size: 85.6mm 53.98mm landscape;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'DejaVu Sans', sans-serif;
            width: 85.6mm;
            height: 53.98mm;
            position: relative;
        }
        .card-container {
            width: 100%;
            height: 100%;
            position: relative;
            background: white;
            overflow: hidden;
        }
        .wave1 {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 45%;
            background-color: #90EE90;
            transform: skewY(-5deg);
            transform-origin: bottom left;
            z-index: 1;
        }
        .wave2 {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 35%;
            background-color: #0B6623;
            transform: skewY(-8deg);
            transform-origin: bottom left;
            z-index: 2;
        }
        .content {
            position: relative;
            z-index: 3;
            padding: 15px;
        }
        .logo {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 50px;
            height: 50px;
        }
        .title {
            color: #0B6623;
            font-size: 15px;
            font-weight: bold;
            margin: 0;
            padding-top: 10px;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 12px;
            color: #333;
            margin-top: 5px;
        }
        .info {
            margin-top: 15px;
            font-size: 10px;
        }
        .info-row {
            margin-bottom: 5px;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 100px;
        }
        .qr-container {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: white;
            padding: 5px;
            border-radius: 5px;
            width: 65px;
            height: 65px;
            z-index: 4;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .qr-container img {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <!-- Background waves -->
        <div class="wave1"></div>
        <div class="wave2"></div>

        <!-- Content -->
        <div class="content">
            <!-- Logo -->
            @if(!empty($logoData))
                <img src="data:image/png;base64,{{ $logoData }}" class="logo" alt="Logo">
            @endif

            <!-- Header -->
            <div class="title">{{ $nasabah->nama }}</div>
            <div class="subtitle">LAYANAN PERBANKAN SYARIAH</div>

            <!-- Information -->
            <div class="info">
                <div class="info-row">
                    <span class="label">ID NASABAH</span>: {{ $nasabah->id_nasabah }}
                </div>
                <div class="info-row">
                    <span class="label">JENIS TABUNGAN</span>: {{ $nasabah->jenis_tabungan }}
                </div>
                <div class="info-row">
                    <span class="label">KELAS</span>: {{ $nasabah->kelas }} {{ $nasabah->jurusan }} {{ $nasabah->angka_kelas }}
                </div>
                <div class="info-row">
                    <span class="label">JENIS KELAMIN</span>: {{ $nasabah->jenis_kelamin }}
                </div>
                <div class="info-row">
                    <span class="label">PHONE</span>: {{ $nasabah->no_telepon }}
                </div>
                
            </div>

            <!-- QR Code -->
            <div class="qr-container">
                <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code">
            </div>
        </div>
    </div>
</body>
</html>