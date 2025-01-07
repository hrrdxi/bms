@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Bagian Foto Kartu Pelajar -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">
                    <strong>Foto Kartu Pelajar</strong>
                </div>
                <div class="card-body text-center">
                    @if($nasabah->foto_kartu_pelajar)
                        <img src="{{ asset('storage/' . $nasabah->foto_kartu_pelajar) }}" 
                             alt="Foto Kartu Pelajar" 
                             class="img-fluid rounded" 
                             style="max-width: 100%; height: auto;">
                    @else
                        <p class="text-muted">Foto tidak tersedia</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Bagian Detail Nasabah -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Detail Nasabah</h3>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>ID Nasabah:</strong> {{ $nasabah->id_nasabah }}</li>
                    <li class="list-group-item"><strong>Nama:</strong> {{ $nasabah->nama }}</li>
                    <li class="list-group-item"><strong>NIS (Nomer Induk Siswa):</strong> {{ $nasabah->no_identitas }}</li> <!-- Menampilkan no_identitas -->
                    <li class="list-group-item"><strong>Jenis Kelamin:</strong> {{ $nasabah->jenis_kelamin }}</li>
                    <li class="list-group-item">
                        <strong>Tempat, Tanggal Lahir:</strong> 
                        {{ $nasabah->tempat_lahir }}, {{ \Carbon\Carbon::parse($nasabah->tanggal_lahir)->format('d F Y') }}
                    </li>
                    <li class="list-group-item"><strong>No Telepon:</strong> {{ $nasabah->no_telepon }}</li>
                    <li class="list-group-item">
                        <strong>Kelas:</strong> {{ $nasabah->kelas }} {{ $nasabah->jurusan }} {{ $nasabah->angka_kelas }}
                    </li>
                    <li class="list-group-item"><strong>Saldo:</strong> Rp. {{ number_format($nasabah->saldo, 0, ',', '.') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat Penarikan -->
    <h3 class="mt-4">Riwayat Penarikan</h3>
    <table class="table table-bordered mt-2">
        <thead class="table-light">
            <tr>
                <th>Tanggal Penarikan</th>
                <th>Jumlah Penarikan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($nasabah->penarikan as $penarikan)
                <tr>
                    <td>{{ $penarikan->tanggal_penarikan ?? 'Tanggal tidak tersedia' }}</td>
                    <td>Rp. {{ number_format($penarikan->jumlah_penarikan, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">Belum ada data penarikan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tabel Riwayat Setoran -->
    <h3 class="mt-4">Riwayat Setoran</h3>
    <table class="table table-bordered mt-2">
        <thead class="table-light">
            <tr>
                <th>Tanggal Setoran</th>
                <th>Jumlah Setoran</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($nasabah->setorans as $setoran)
                <tr>
                    <td>{{ $setoran->tanggal_transaksi ?? 'Tanggal tidak tersedia' }}</td>
                    <td>Rp. {{ number_format($setoran->jumlah_setoran, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">Belum ada data setoran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
