@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<head>
    <style>
        /* Basic table styling */
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

        /* Pagination styling */
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

        /* Responsive adjustments for mobile devices */
        @media (max-width: 768px) {
            /* Adjust table font size and padding */
            .table td, .table th {
                font-size: 12px;
                padding: 3px;
            }

            /* Stack action buttons vertically on smaller screens */
            .table .action-buttons {
                flex-direction: column;
                gap: 4px;
            }

            /* Smaller button text and padding */
            .btn-action {
                font-size: 12px;
                padding: 3px 8px;
            }

            /* Smaller pagination controls */
            .pagination a, .pagination span {
                padding: 3px 8px;
                font-size: 12px;
            }

            /* Ensure pagination and button container wrap properly */
            .d-flex {
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Penarikan Uang</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <div class="mb-2">
            <a href="{{ route('penarikan.create') }}" class="btn btn-success btn-action mb-2">
                <i class="fas fa-plus"></i> Tambah Penarikan Uang
            </a>
            <a href="#" class="btn btn-primary btn-action mb-2">
                <i class="fas fa-calendar-day"></i> Cek Hari Ini
            </a>
            <a href="#" class="btn btn-danger btn-action mb-2">
                <i class="fas fa-eye"></i> Cek Semua Penarikan
            </a>
        </div>
        <a href="#" class="btn btn-warning mb-2">
            <i class="fas fa-file-export"></i> Export Per Tanggal
        </a>
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
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $penarikan->id_penarikan }}</td>
                        <td>{{ $penarikan->nama_nasabah }}</td>
                        <td>{{ $penarikan->kelas }}</td>
                        <td>{{ $penarikan->keterangan_penarikan }}</td>
                        <td>{{ \Carbon\Carbon::parse($penarikan->tanggal_penarikan)->format('d F Y') }}</td>
                        <td>Rp. {{ number_format($penarikan->jumlah_penarikan, 0, ',', '.') }}</td>
                        <td class="action-buttons">
                            <a href="{{ route('penarikan.edit', $penarikan->id) }}" class="btn btn-warning btn-sm btn-action">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('penarikan.destroy', $penarikan->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm btn-action" onclick="return confirm('Yakin ingin menghapus?')">
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
@endsection
