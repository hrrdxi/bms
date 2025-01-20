@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Data Bulanan</h1>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nama Nasabah</th>
                <th>Tanggal Transaksi</th>
                <th>Jumlah Setoran</th>
                <th>Jumlah Penarikan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($setoranBulanan as $setoran)
            <tr>
                <td>{{ $setoran->nama_nasabah }}</td>
                <td>{{ $setoran->tanggal_transaksi->format('d-m-Y') }}</td>
                <td>{{ number_format($setoran->jumlah_setoran, 2, ',', '.') }}</td>
                <td>-</td>
            </tr>
            @endforeach
            @foreach ($penarikanBulanan as $penarikan)
            <tr>
                <td>{{ $penarikan->nama_nasabah }}</td>
                <td>{{ $penarikan->tanggal_penarikan->format('d-m-Y') }}</td>
                <td>-</td>
                <td>{{ number_format($penarikan->jumlah_penarikan, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection