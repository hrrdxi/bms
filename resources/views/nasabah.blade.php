{{-- nasabah.blade.php --}}
@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<head>
    <style>
        .table {
            width: 100%;
            table-layout: auto;
            font-size: 14px;
        }
        .table thead {
            background-color: #00a1e0;
            color: white;
        }
        .table td, .table th {
            white-space: nowrap;
            padding: 5px;
        }
        .table .action-buttons {
            display: flex;
            justify-content: center;
            gap: 8px;
        }
        .table tbody tr:hover {
            background-color: #e6f7ff;
        }
        .pagination a, .pagination span {
            background-color: #00a1e0;
            color: white;
            padding: 5px 15px;
            margin: 2px;
            border-radius: 12px;
            transition: background-color 0.3s, border-radius 0.3s;
        }
        .pagination a:hover, .pagination .active span {
            background-color: #007bbd;
            border-radius: 25px;
        }
        .pagination .active span, .pagination .page-item.disabled span {
            pointer-events: none;
        }
        @media (max-width: 768px) {
            .table .action-buttons {
                flex-direction: column;
            }
            .table td, .table th {
                font-size: 12px;
                padding: 3px;
            }
            .btn-action {
                font-size: 12px;
                padding: 3px 8px;
            }
            .pagination a, .pagination span {
                padding: 3px 10px;
                font-size: 12px;
            }
        }
    </style>
</head>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manajemen Nasabah</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <div>
            <a href="{{ route('nasabah.create') }}" class="btn btn-success btn-action mb-2">
                <i class="fas fa-plus"></i> Tambah Nasabah
            </a>
            <a href="{{ route('nasabah.cekSemua') }}" class="btn btn-primary btn-action mb-2">
                <i class="fas fa-eye"></i> Cek Semua Nasabah
            </a>
        </div>
        <a href="" class="btn btn-warning mb-2">
            <i class="fas fa-file-export"></i> Export Data Nasabah
        </a>

        <form action="{{ route('nasabah.search') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama atau ID Nasabah" 
                       value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('nasabah.search') }}" class="btn btn-secondary">
                        <i class="fas fa-reset"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>ID Nasabah</th>
                    <th>Jenis Tabungan</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Nomor Identitas (NIS)</th>
                    <th>No Telepon</th>
                    <th>Kelas</th>
                    <th>Saldo</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nasabahs as $nasabah)
                    <tr>
                        <td>{{ ($nasabahs->currentPage() - 1) * $nasabahs->perPage() + $loop->iteration }}</td>
                        <td>{{ $nasabah->id_nasabah }}</td>
                        <td>{{ $nasabah->jenis_tabungan }}</td>
                        <td>{{ $nasabah->nama }}</td>
                        <td>{{ $nasabah->jenis_kelamin }}</td>
                        <td>{{ $nasabah->no_identitas }}</td>
                        <td>{{ $nasabah->no_telepon }}</td>
                        <td>
                            @if($nasabah->jurusan === null)
                                {{ $nasabah->kelas }}
                            @else
                                {{ $nasabah->kelas }} {{ $nasabah->jurusan }}
                                @if(!is_null($nasabah->angka_kelas) && $nasabah->angka_kelas !== 'Tidak Ada')
                                    {{ $nasabah->angka_kelas }}
                                @endif
                            @endif
                        </td>                                                              
                        <td>Rp. {{ number_format($nasabah->saldo, 0, ',', '.') }}</td>
                        <td class="action-buttons">
                            <a href="{{ route('nasabah.show', $nasabah->id) }}" class="btn btn-info btn-sm btn-action">
                                <i class="fas fa-info-circle"></i>
                            </a>                            
                            <a href="{{ route('nasabah.edit', $nasabah->id) }}" class="btn btn-warning btn-sm btn-action">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('nasabah.destroy', $nasabah->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm btn-action" onclick="return confirm('Apakah Anda yakin ingin menghapus nasabah ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>Menampilkan {{ $nasabahs->firstItem() }} sampai {{ $nasabahs->lastItem() }} dari {{ $nasabahs->total() }} entri</div>
        <div class="pagination-wrapper">
            <ul class="pagination pagination-sm">
                @if($nasabahs->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Sebelumnya</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $nasabahs->previousPageUrl() }}" rel="prev">Sebelumnya</a></li>
                @endif

                <li class="page-item active"><span class="page-link">{{ $nasabahs->currentPage() }}</span></li>

                @if($nasabahs->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $nasabahs->nextPageUrl() }}" rel="next">Selanjutnya</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Selanjutnya</span></li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection