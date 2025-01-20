@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Setoran Hari Ini</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>ID Setoran</th>
                    <th>Nama Nasabah</th>
                    <th>Kelas</th>
                    <th>Tanggal Setoran</th>
                    <th>Jumlah Setoran</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($setorans as $setoran)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $setoran->id_setoran }}</td>
                        <td>{{ $setoran->nama_nasabah }}</td>
                        <td>{{ $setoran->kelas }}</td>
                        <td>{{ \Carbon\Carbon::parse($setoran->tanggal_setoran)->format('d F Y') }}</td>
                        <td>Rp. {{ number_format($setoran->jumlah_setoran, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper mt-3">
        {{ $setorans->links() }}
    </div>
</div>
@endsection
