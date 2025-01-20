@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Semua Penarikan</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>ID Penarikan</th>
                    <th>Nama Nasabah</th>
                    <th>Kelas</th>
                    <th>Keterangan Penarikan</th>
                    <th>Tanggal Penarikan</th>
                    <th>Jumlah Penarikan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penarikans as $penarikan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $penarikan->id_penarikan }}</td>
                        <td>{{ $penarikan->nama_nasabah }}</td>
                        <td>{{ $penarikan->kelas }}</td>
                        <td>{{ $penarikan->keterangan_penarikan }}</td>
                        <td>{{ \Carbon\Carbon::parse($penarikan->tanggal_penarikan)->format('d F Y') }}</td>
                        <td>Rp. {{ number_format($penarikan->jumlah_penarikan, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $penarikans->links() }}
    </div>
</div>
@endsection
