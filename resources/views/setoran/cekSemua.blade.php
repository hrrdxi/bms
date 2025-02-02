@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Semua Setoran</h1>

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
                        <td>{{ ($setorans->currentPage() - 1) * $setorans->perPage() + $loop->iteration }}</td>
                        <td>{{ $setoran->id_setoran }}</td>
                        <td>{{ $setoran->nama_nasabah }}</td>
                        <td>{{ $setoran->kelas }}</td>
                        <td>{{ \Carbon\Carbon::parse($setoran->tanggal_transaksi)->format('d F Y') }}</td>
                        <td>Rp. {{ number_format($setoran->jumlah_setoran, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-left align-items-left mt-4">
        @if($setorans->lastPage() > 1)
        <nav>
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if($setorans->currentPage() > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $setorans->previousPageUrl() }}" rel="prev">
                            Previous
                        </a>
                    </li>
                @endif
    
                {{-- Next Page Link --}}
                @if($setorans->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $setorans->nextPageUrl() }}" rel="next">
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
