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
                        <td>{{ ($penarikans->currentPage() - 1) * $penarikans->perPage() + $loop->iteration }}</td>
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
    <div class="d-flex justify-content-left align-items-left mt-4">
        @if($penarikans->lastPage() > 1)
        <nav>
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if($penarikans->currentPage() > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $penarikans->previousPageUrl() }}" rel="prev">
                            Previous
                        </a>
                    </li>
                @endif
    
                {{-- Next Page Link --}}
                @if($penarikans->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $penarikans->nextPageUrl() }}" rel="next">
                            Next
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        @endif
    </div>
</div>
@endsection
