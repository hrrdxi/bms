@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Transaksi Penarikan</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Pengajuan Transaksi -->
    <form action="{{ route('transaksis.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="amount">Jumlah Penarikan</label>
            <input type="number" name="amount" id="amount" class="form-control" placeholder="Masukkan jumlah penarikan" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Ajukan Penarikan</button>
    </form>

    <!-- Tabel Riwayat Transaksi -->
    <h2 class="mt-4">Riwayat Transaksi</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->created_at->format('d-m-Y H:i') }}</td>
                    <td>Rp {{ number_format($transaksi->amount, 2, ',', '.') }}</td>
                    <td>
                        <span class="badge 
                            @if($transaksi->status == 'pending') bg-warning text-dark
                            @elseif($transaksi->status == 'approved') bg-success
                            @else bg-danger @endif">
                            {{ ucfirst($transaksi->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada riwayat transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
