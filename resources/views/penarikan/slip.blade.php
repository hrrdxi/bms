<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Penarikan Tunai</title>
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
            Ciawi
        </div>

        <div class="title">BUKTI PENARIKAN TUNAI</div>

        <div class="info-container">
            <div class="left-section">
                <div class="info-row">
                    <span class="label">Tanggal Transaksi</span><span class="separator">:</span><span class="value">{{ \Carbon\Carbon::parse($penarikan->tanggal_penarikan)->format('d F Y / H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Nomor Transaksi</span><span class="separator">:</span><span class="value">{{ $penarikan->id_penarikan }}</span>
                </div>
                <div class="info-row">
                    <span class="label">ID Anggota</span><span class="separator">:</span><span class="value">{{ $penarikan->id_nasabah }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Nama Anggota</span><span class="separator">:</span><span class="value">{{ $penarikan->nama_nasabah }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Kelas</span><span class="separator">:</span><span class="value">{{ $penarikan->kelas }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Keterangan</span><span class="separator">:</span><span class="value">{{ $penarikan->keterangan_penarikan }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Jumlah Penarikan</span><span class="separator">:</span><span class="value">Rp. {{ number_format($penarikan->jumlah_penarikan, 0, ',', '.') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Terbilang</span><span class="separator">:</span><span class="value">{{ $penarikan->terbilang }}</span>
                </div>
            </div>

            <div class="right-section">
                <div class="info-row">
                    <span class="label">Tanggal Cetak</span><span class="separator">:</span><span class="value">{{ \Carbon\Carbon::now()->format('d F Y / H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">User Akun</span><span class="separator">:</span><span class="value">{{ auth()->user()->name ?? 'admin' }}</span>
                </div>

                <div class="signature-section">
                    Paraf Petugas,
                    <div class="signature-line"></div>
                </div>

                <div class="signature-section" style="margin-top: 60px;">
                    Penerima,
                    <div class="signature-line"></div>
                    {{ $penarikan->nama_nasabah }}
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="reference">Ref. {{ $penarikan->id_penarikan }}</div>
            <div>Informasi Hubungi Call Center : {{ config('app.phone', '02518241986') }}</div>
            <div>atau dapat diakses melalui : {{ config('app.url', 'www.smkamaliah.sch.id') }}</div>
            <div style="margin-top: 20px;">
                ** Tanda terima ini sah jika telah dibubuhi cap dan tanda tangan oleh Petugas dan Penerima **
            </div>
        </div>
    </div>
</body>
</html>