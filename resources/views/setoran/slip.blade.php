<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Setoran Tunai</title>
    <style>
        @page {
            size: landscape;
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
        }
        .header-right {
            position: absolute;
            top: 20px;
            right: 20px;
            text-align: right;
        }
        .title {
            font-weight: bold;
            font-size: 14px;
            border-bottom: 1px solid black;
            display: inline-block;
            margin-bottom: 20px;
        }
        .info-container {
            display: flex;
            justify-content: space-between;
            gap: 40px;
        }
        .left-section {
            flex: 2;
        }
        .right-section {
            flex: 1;
        }
        .info-row {
            line-height: 1.5;
        }
        .label {
            display: inline-block;
            width: 150px;
        }
        .separator {
            display: inline-block;
            margin: 0 5px;
        }
        .value {
            display: inline-block;
        }
        .signature-section {
            margin-top: 30px;
            text-align: right;
        }
        .signature-line {
            margin-top: 40px;
            width: 200px;
            border-top: 1px solid black;
            display: inline-block;
        }
        .img {
        text-align: center;
        margin-top: -251px;
        margin-right: 10px; /* Gunakan titik koma (;) dan ubah koma menjadi titik */
}

        .logo {
        max-width: 350px;
        height: auto;
        opacity: 0.6; /* Nilai opacity diubah menjadi 0.6 untuk efek samar */
        filter: blur(2px) brightness(0.9); /* Tambahkan efek blur ringan dan kurangi kecerahan */
        }
        .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 10px;
            font-style: italic;
        }
        .reference {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-right">
            SMK AMALIAH 1 & 2<br>
            Ciawii
        </div>

        <div class="title">BUKTI SETORAN TUNAI</div>

        <div class="info-container">
            <div class="left-section">
                <div class="info-row">
                    <span class="label">Tanggal Transaksi</span><span class="separator">:</span><span class="value">{{ \Carbon\Carbon::parse($setoran->created_at)->format('d F Y / H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Nomor Transaksi</span><span class="separator">:</span><span class="value">{{ $setoran->id_setoran }}</span>
                </div>
                <div class="info-row">
                    <span class="label">ID Anggota</span><span class="separator">:</span><span class="value">{{ $setoran->id_nasabah }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Nama Anggota</span><span class="separator">:</span><span class="value">{{ $setoran->nama_nasabah }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Jumlah Setoran</span><span class="separator">:</span><span class="value">Rp. {{ number_format($setoran->jumlah_setoran, 0, ',', '.') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Terbilang</span><span class="separator">:</span><span class="value">{{ $setoran->terbilang }}</span>
                </div>
            </div>

            <div class="right-section">
                <div class="info-row">
                    <span class="label">Tanggal Cetak</span><span class="separator">:</span><span class="value">{{ \Carbon\Carbon::now()->format('d F Y / H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">User Akun</span><span class="separator">:</span><span class="value">{{ auth()->user()->name ?? 'admin' }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Status</span><span class="separator">:</span><span class="value">{{ $setoran->status }}</span>
                </div>

                <div class="signature-section">
                    Paraf Petugas,
                    <div class="signature-line"></div>
                </div>

                <div class="signature-section" style="margin-top: 60px;">
                    Penerima,
                    <div class="signature-line"></div>
                    {{ $setoran->nama_nasabah }}
                </div>
            </div>
        </div>
                <div class="img">
    <img src="asset/image/smk3.png" alt="" class="logo">
        </div>
        <div class="footer">
            <div class="reference">Ref. {{ $setoran->ref_number ?? date('YmdHis') }}</div>
            <div>Informasi Hubungi Call Center : {{ config('app.phone', '02518241986') }}</div>
            <div>atau dapat diakses melalui : {{ config('app.url', 'www.smkamaliah.sch.id') }}</div>
            <div style="margin-top: 20px;">
                ** Tanda terima ini sah jika telah dibubuhi cap dan tanda tangan oleh Admin **
            </div>
        </div>
    </div>
</body>
</html>