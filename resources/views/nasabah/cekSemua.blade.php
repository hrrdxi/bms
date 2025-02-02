@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Semua Nasabah</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>ID Nasabah</th>
                    <th>Nama Nasabah</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Angka Kelas</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($nasabahs as $nasabah)
                    <tr>
                        <td>{{ $loop->iteration + ($nasabahs->currentPage() - 1) * $nasabahs->perPage() }}</td>
                        <td>{{ $nasabah->id_nasabah }}</td>
                        <td>{{ $nasabah->nama }}</td>
                        <td>{{ $nasabah->kelas }}</td>
                        <td>{{ $nasabah->jurusan }}</td>
                        <td>{{ $nasabah->angka_kelas ?? 'Tidak Ada' }}</td>
                        <td>Rp. {{ number_format($nasabah->saldo, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-left align-items-left mt-4">
        @if($nasabahs->lastPage() > 1)
        <nav>
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if($nasabahs->currentPage() > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $nasabahs->previousPageUrl() }}" rel="prev">
                            Previous
                        </a>
                    </li>
                @endif
    
                {{-- Next Page Link --}}
                @if($nasabahs->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $nasabahs->nextPageUrl() }}" rel="next">
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
