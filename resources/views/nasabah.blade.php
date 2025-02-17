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
            font-size: 12px;
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
        .btn-action {
    min-width: 100px;
    padding: 8px 12px;
    font-size: 12px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px; /* Jarak ikon dan teks */
}

.d-flex.flex-wrap.gap-2 {
    gap: 12px;
}

/* ======== Styling Form Search ======== */
.input-group {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    width: 100%;
}

.input-group .form-control {
    flex-grow: 1;
    min-width: 100px;
    padding: 8px 10px;
    border-radius: 5px;
}

.input-group .btn {
    min-width: 120px;
    padding: 8px 12px;
    font-size: 12px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}

.table .action-buttons {
    display: flex;
    gap: 3px;  /* Mengurangi jarak antar tombol */
    justify-content: flex-start;
}

.table .btn-action {
    padding: 3px 6px;  /* Mengurangi padding */
    font-size: 11px;   /* Memperkecil ukuran font */
    min-width: 55px;   /* Mengurangi lebar minimum */
    height: 24px;      /* Mengatur tinggi tetap */
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.table .btn-action i {
    font-size: 10px;    /* Memperkecil ukuran icon */
    margin-right: 3px;  /* Mengurangi jarak icon dengan teks */
}

/* Menyesuaikan ukuran tombol form hapus */
.table form {
    margin: 0;
    padding: 0;
    display: inline;
}

.table .btn-danger.btn-action {
    margin: 0;
    border: none;
}

/* Responsif untuk layar kecil */
@media (max-width: 768px) {
    .table .action-buttons {
        flex-direction: row;  /* Tetap dalam satu baris */
        gap: 2px;            /* Jarak lebih kecil pada mobile */
    }
    
    .table .btn-action {
        padding: 2px 4px;
        font-size: 10px;
    }
}

/* Responsif untuk layar kecil */
@media (max-width: 768px) {
    .table td, .table th {
        font-size: 12px;
        padding: 6px;
    }

    .btn-action {
        min-width: 100px;
        font-size: 12px;
        padding: 6px 10px;
    }

    .input-group {
        flex-direction: column;
        align-items: stretch;
    }

    .input-group .form-control {
        min-width: 100%;
    }

    .input-group .btn {
        width: 100%;
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
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('nasabah.create') }}" class="btn btn-success btn-action">
                <i class="fas fa-plus"></i> Tambah
            </a>
            <a href="{{ route('nasabah.cekSemua') }}" class="btn btn-primary btn-action">
                <i class="fas fa-eye"></i> Semua
            </a>
            <a href="#" class="btn btn-warning btn-action">
                <i class="fas fa-file-export"></i> Export
            </a>
        </div>        

        <form action="{{ route('nasabah.search') }}" method="GET" class="d-flex flex-grow-1">
            <div class="input-group">
                <input type="text" 
                       name="search" 
                       class="form-control" 
                       placeholder="Cari Nama atau ID Nasabah" 
                       value="{{ request('search') }}">
        
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> Cari
                </button>
        
                <a href="{{ route('nasabah.search') }}" class="btn btn-secondary">
                    <i class="fas fa-undo"></i> Reset
                </a>
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
                            <a href="{{ route('nasabah.show', $nasabah->id) }}" 
                               class="btn btn-info btn-sm btn-action">
                                <i class="fas fa-info-circle"></i> Detail
                            </a>                            
                            <a href="{{ route('nasabah.edit', $nasabah->id) }}" 
                               class="btn btn-warning btn-sm btn-action">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('nasabah.destroy', $nasabah->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm btn-action" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus nasabah ini?')">
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