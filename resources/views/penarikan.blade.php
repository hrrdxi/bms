@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* Existing styles */
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
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    width: 100%;
}

.input-group .form-control {
    flex-grow: 1; /* Agar input field menyesuaikan ukuran */
    min-width: 250px;
    padding: 8px 12px;
    border-radius: 5px;
}

.input-group .btn {
    min-width: 100px; /* Agar tombol Cari dan Reset memiliki ukuran seragam */
    padding: 8px 12x;
    font-size: 14px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px; /* Jarak antara ikon dan teks */
}

/* Responsif untuk layar kecil */
@media (max-width: 768px) {
    .input-group {
        flex-direction: column;
        align-items: stretch;
    }

    .input-group .form-control {
        min-width: 100%;
    }

    .input-group .btn {
        width: 100%; /* Agar tombol memenuhi lebar pada layar kecil */
    }
}

    .btn-action {
    min-width: 40px; /* Agar tombol memiliki ukuran yang seragam */
    padding: 8px 10px;
    font-size: 13px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px; /* Jarak antara ikon dan teks */
}

.d-flex.flex-wrap.gap-2 {
    gap: 12px; /* Jarak antar tombol lebih konsisten */
}

.input-group .btn {
    min-width: 120px; /* Agar tombol cari dan reset seragam */
}

/* Styling khusus untuk button aksi dalam tabel */
.table .action-buttons {
    display: flex;
    gap: 3px;  /* Jarak antar tombol diperkecil */
    justify-content: flex-start;
}

.table .btn-action {
    padding: 3px 6px;  /* Padding diperkecil */
    font-size: 11px;   /* Ukuran font diperkecil */
    min-width: 55px;   /* Lebar minimum diperkecil */
    height: 24px;      /* Tinggi tetap */
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.table .btn-action i {
    font-size: 10px;    /* Ukuran icon diperkecil */
    margin-right: 3px;  /* Jarak icon dengan teks diperkecil */
}

/* Menyesuaikan tombol dalam form hapus */
.table form {
    margin: 0;
    padding: 0;
    display: inline;
}

.table .btn-danger.btn-action {
    margin: 0;
    border: none;
}

/* Responsif untuk mobile */
@media (max-width: 768px) {
    .table .action-buttons {
        flex-direction: row;  
        gap: 2px;            
    }
    
    .table .btn-action {
        padding: 2px 4px;
        font-size: 10px;
    }
}

@media (max-width: 768px) {
    .btn-action {
        min-width: 100px;
        font-size: 12px;
        padding: 6px 10px;
    }
}

</style>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Penarikan Masuk</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('success') && session('last_penarikan_id'))
    <div class="popup-overlay" id="printPopup">
        <div class="popup-content">
            <h4 class="text-center mb-3">Penarikan Berhasil Ditambahkan!</h4>
            <p class="text-center mb-4">Apakah Anda ingin mencetak slip penarikan sekarang?</p>
            <div class="popup-buttons">
                @if(session('last_penarikan_id'))
                    <a href="{{ route('penarikan.print-slip', ['id' => session('last_penarikan_id')]) }}" 
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
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('penarikan.create') }}" class="btn btn-success btn-action">
                <i class="fas fa-plus"></i> Tambah
            </a>
            <a href="{{ route('penarikan.cekHariIni') }}" class="btn btn-primary btn-action">
                <i class="fas fa-calendar-day"></i> Hari Ini
            </a>
            <a href="{{ route('penarikan.cekSemua') }}" class="btn btn-danger btn-action">
                <i class="fas fa-eye"></i> Semua
            </a>
            <a href="#" class="btn btn-warning btn-action">
                <i class="fas fa-file-export"></i> Export
            </a>
        </div>
    
        <form action="{{ route('penarikan.search') }}" method="GET" class="d-flex flex-grow-1">
            <div class="input-group">
                <input type="text" 
                       name="search" 
                       class="form-control" 
                       placeholder="Cari Nama atau ID Penarikan" 
                       value="{{ request('search') }}">
        
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> Cari
                </button>
        
                <a href="{{ route('penarikan.search') }}" class="btn btn-secondary">
                    <i class="fas fa-undo"></i> Reset
                </a>
            </div>
        </form>
    </div>        

    <!-- Responsive table -->
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
                    <th>Aksi</th>
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
                        <td class="action-buttons">
                            <a href="{{ route('penarikan.download-slip', $penarikan->id) }}" 
                               class="btn btn-info btn-sm btn-action">
                                <i class="fas fa-download"></i> Slip
                            </a>
                            <a href="{{ route('penarikan.edit', $penarikan->id) }}" 
                               class="btn btn-warning btn-sm btn-action">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('penarikan.destroy', $penarikan->id) }}" 
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

    <!-- Pagination control with flex-wrap for responsiveness -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mt-3">
        <div class="mb-2">
            Menampilkan {{ $penarikans->firstItem() }} sampai {{ $penarikans->lastItem() }} dari {{ $penarikans->total() }} entri
        </div>
        <div class="pagination-wrapper">
            <ul class="pagination pagination-sm">
                @if($penarikans->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Sebelumnya</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $penarikans->previousPageUrl() }}" rel="prev">Sebelumnya</a></li>
                @endif

                <li class="page-item active"><span class="page-link">{{ $penarikans->currentPage() }}</span></li>

                @if($penarikans->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $penarikans->nextPageUrl() }}" rel="next">Selanjutnya</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Selanjutnya</span></li>
                @endif
            </ul>
        </div>
    </div>
</div>

@if(session('success') && session('last_penarikan_id') && request()->routeIs('penarikan.index'))
    <script>
        console.log('Popup should appear');
        document.getElementById('printPopup').style.display = 'block';
    </script>
    @endif
@endsection