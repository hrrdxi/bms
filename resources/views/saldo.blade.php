@extends('layouts.main')

@section('content')

<div class="container">
    <h2>Manajemen Saldo Nasabah</h2>

    {{-- Menampilkan pesan sukses jika ada --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Menampilkan pesan error jika ada --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Form untuk mencari nasabah --}}
    <form action="{{ route('saldo.index') }}" method="GET" class="mb-4">
        <div class="form-group">
            <label for="search">Cari Nasabah</label>
            <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Nama atau ID Nasabah">
        </div>
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>

    {{-- Form untuk mengecek saldo nasabah --}}
    <form action="{{ route('saldo.cek') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nasabah_id">Pilih Nasabah</label>
            <select name="nasabah_id" id="nasabah_id" class="form-control" required>
                <option value="" disabled selected>Pilih Nasabah</option>
                @foreach ($nasabahs as $nasabah)
                    <option value="{{ $nasabah->id }}">{{ $nasabah->nama }} ({{ $nasabah->id_nasabah }})</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cek Saldo</button>
    </form>

    {{-- Tabel daftar saldo --}}
    <div class="card mt-4">
        <div class="card-header">
            Daftar Saldo Nasabah
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Nasabah</th>
                        <th>ID Nasabah</th>
                        <th>Saldo Awal</th>
                        <th>Saldo Akhir</th>
                        <th>Setoran</th>
                        <th>Penarikan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($saldos as $index => $saldo)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $saldo->nasabah->nama }}</td>
                            <td>{{ $saldo->nasabah->id_nasabah }}</td>
                            <td>{{ number_format($saldo->saldo_awal, 2, ',', '.') }}</td>
                            <td>{{ number_format($saldo->saldo_akhir, 2, ',', '.') }}</td>
                            <td>
                                @foreach ($saldo->nasabah->setorans as $setoran)
                                    <div>{{ $setoran->jumlah_setoran }} ({{ $setoran->tanggal_transaksi }})</div>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($saldo->nasabah->penarikan as $penarikan)
                                    <div>{{ $penarikan->jumlah_penarikan }} ({{ $penarikan->tanggal_penarikan }})</div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            {{ $saldos->links() }}
        </div>
    </div>
</div>

@endsection
