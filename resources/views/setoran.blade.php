{{-- setoran.blade.php --}}
@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<head>
    <style>
        /* Existing styles */
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
            padding: 5px 10px;
            margin: 2px;
            border-radius: 12px;
            text-decoration: none;
            transition: background-color 0.3s, border-radius 0.3s;
        }
    
        .pagination a:hover, .pagination .active span {
            background-color: #007bbd;
            border-radius: 25px;
        }
    
        /* New styles for popup */
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1050;
        }
    
        .popup-content {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.2);
            z-index: 1051;
            min-width: 300px;
        }
    
        .popup-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
    
        .input-group {
        display: flex;
        gap: 8px;
        margin-bottom: 7px;
    }
    
    .input-group .form-control {
        border-radius: 4px;
        padding: 6px 12px;
        margin-bottom: 7px;
    }
    
        @media (max-width: 768px) {
            .table td, .table th {
                font-size: 12px;
                padding: 3px;
            }
    
            .table .action-buttons {
                flex-direction: column;
                gap: 4px;
            }
    
            .btn-action {
                font-size: 12px;
                padding: 3px 8px;
            }
        }
    
        .btn-action {
            min-width: 120px; /* Agar tombol seragam */
        }
    
        .d-flex.flex-wrap.gap-2 .btn-action {
            margin-right: 8px; /* Memberi jarak antar tombol */
            margin-bottom: 8px; /* Jarak antar baris di layar kecil */
        }
    
        .input-group .btn {
            min-width: 100px; /* Ukuran tombol Cari dan Reset */
            margin-right: 10px;
        }
    </style>
</head>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Setoran Masuk</h1>

    @if(session('success') && session('last_setoran_id'))
    <div class="popup-overlay" id="printPopup">
        <div class="popup-content">
            <h4 class="text-center mb-3">Setoran Berhasil Ditambahkan!</h4>
            <p class="text-center mb-4">Apakah Anda ingin mencetak slip setoran sekarang?</p>
            <div class="popup-buttons">
                @if(session('last_setoran_id'))
                    <a href="{{ route('setoran.print-slip', ['id' => session('last_setoran_id')]) }}" 
                       class="btn btn-primary">
                        <i class="fas fa-print me-1"></i> Cetak Slip
                    </a>
                @else
                    <button class="btn btn-primary" disabled>
                        <i class="fas fa-print me-1"></i> Cetak Slip (Tidak Tersedia)
                    </button>
                @endif
                <button class="btn btn-secondary" 
                        onclick="document.getElementById('printPopup').style.display='none'">
                    Nanti Saja
                </button>
            </div>
        </div>
    </div>
@endif

<div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
    <!-- Grup tombol aksi -->
    <div class="d-flex flex-wrap gap-2 mb-2">
        <a href="{{ route('setoran.create') }}" class="btn btn-success btn-action">
            <i class="fas fa-plus"></i> Tambah Setoran Uang
        </a>
        <a href="{{ route('setoran.cekHariIni') }}" class="btn btn-primary btn-action">
            <i class="fas fa-calendar-day"></i> Cek Hari Ini
        </a>
        <a href="{{ route('setoran.cekSemua') }}" class="btn btn-danger btn-action">
            <i class="fas fa-eye"></i> Cek Semua Setoran
        </a>
        <a href="#" class="btn btn-warning btn-action">
            <i class="fas fa-file-export"></i> Export Per Tanggal
        </a>
    </div>

    <form action="{{ route('setoran.search') }}" method="GET" class="d-flex flex-grow-1">
        <div class="input-group">
            <input type="text" 
                   name="search" 
                   class="form-control" 
                   placeholder="Cari Nama atau ID setoran" 
                   value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search"></i> Cari
            </button>
            <a href="{{ route('setoran.search') }}" class="btn btn-secondary" >
                <i class="fas fa-undo"></i> Reset
            </a>
        </div>
    </form>
</div>
</div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>ID Setoran</th>
                    <th>Nama Nasabah</th>
                    <th>ID Nasabah</th>
                    <th>Kelas</th>
                    <th>Tanggal Transaksi</th>
                    <th>Jumlah Setoran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($setorans as $setoran)
                    <tr>
                        <td>{{ ($setorans->currentPage() - 1) * $setorans->perPage() + $loop->iteration }}</td>
                        <td>{{ $setoran->id_setoran }}</td>
                        <td>{{ $setoran->nama_nasabah }}</td>
                        <td>{{ $setoran->id_nasabah }}</td>
                        <td>{{ $setoran->kelas }}</td>
                        <td>{{ \Carbon\Carbon::parse($setoran->tanggal_transaksi)->format('d F Y') }}</td>
                        <td>Rp. {{ number_format($setoran->jumlah_setoran, 0, ',', '.') }}</td>
                        <td class="action-buttons">
                            <a href="{{ route('setoran.download-slip', $setoran->id) }}" 
                               class="btn btn-info btn-sm btn-action">
                                <i class="fas fa-download"></i> Slip
                            </a>
                            <a href="{{ route('setoran.edit', $setoran->id) }}" 
                               class="btn btn-warning btn-sm btn-action">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('setoran.destroy', $setoran->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm btn-action" 
                                        onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap mt-3">
        <div class="mb-2">
            Menampilkan {{ $setorans->firstItem() }} sampai {{ $setorans->lastItem() }} dari {{ $setorans->total() }} entri
        </div>
        <div class="pagination-wrapper">
            <ul class="pagination pagination-sm">
                @if($setorans->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Sebelumnya</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $setorans->previousPageUrl() }}" rel="prev">Sebelumnya</a></li>
                @endif

                <li class="page-item active"><span class="page-link">{{ $setorans->currentPage() }}</span></li>

                @if($setorans->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $setorans->nextPageUrl() }}" rel="next">Selanjutnya</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Selanjutnya</span></li>
                @endif
            </ul>
        </div>
    </div>
</div>

    @if(session('success') && session('last_setoran_id') && request()->routeIs('setoran.index'))
    <script>
        console.log('Popup should appear');
        document.getElementById('printPopup').style.display = 'block';
    </script>
    @endif
@endsection