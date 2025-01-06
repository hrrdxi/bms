@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<head>
    <style>
        /* Table should take full width of the screen and adjust column widths based on content */
        .table {
            width: 100%;
            table-layout: auto; /* Allows the table to adjust column width based on content */
            font-size: 14px; /* Slightly smaller font size for better fit */
        }

        /* Adjust header styles */
        .table thead {
            background-color: #00a1e0;
            color: white;
        }

        /* Ensure text is visible and doesn't wrap unnecessarily */
        .table td, .table th {
            white-space: nowrap; /* Prevent text from wrapping */
            padding: 5px; /* Decrease padding for more space */
        }

        /* Ensures that action buttons fit nicely and aren't too close */
        .table .action-buttons {
            display: flex;
            justify-content: center;
            gap: 8px; /* Adjust gap between buttons */
        }

        /* Hover effect for rows */
        .table tbody tr:hover {
            background-color: #e6f7ff;
        }

        /* Style pagination */
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

        .pagination .active span, .pagination .page-item.disabled span {
            pointer-events: none;
        }

        /* Responsive adjustments for mobile devices */
        @media (max-width: 768px) {
            .table td, .table th {
                font-size: 12px;
                padding: 3px;
            }

            /* Stack buttons vertically on smaller screens */
            .table .action-buttons {
                flex-direction: column;
                gap: 4px;
            }

            /* Make button text smaller */
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
    <h1 class="h3 mb-4 text-gray-800">Setoran Masuk</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <div class="mb-2">
            <a href="{{ route('setoran.create') }}" class="btn btn-success btn-action mb-2">
                <i class="fas fa-plus"></i> Tambah Setoran Masuk
            </a>
            <a href="#" class="btn btn-primary btn-action mb-2">
                <i class="fas fa-calendar-day"></i> Cek Hari Ini
            </a>
            <a href="#" class="btn btn-danger btn-action mb-2">
                <i class="fas fa-eye"></i> Cek Semua Setoran
            </a>
        </div>
        <a href="#" class="btn btn-warning mb-2">
            <i class="fas fa-file-export"></i> Export Per Tanggal
        </a>
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
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $setoran->id_setoran }}</td>
                        <td>{{ $setoran->nama_nasabah }}</td>
                        <td>{{ $setoran->id_nasabah }}</td>
                        <td>{{ $setoran->kelas }}</td>
                        <td>{{ \Carbon\Carbon::parse($setoran->tanggal_transaksi)->format('d F Y') }}</td>
                        <td>Rp. {{ number_format($setoran->jumlah_setoran, 0, ',', '.') }}</td>
                        <td class="action-buttons">
                            <a href="{{ route('setoran.edit', $setoran->id) }}" class="btn btn-warning btn-sm btn-action">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('setoran.destroy', $setoran->id) }}" method="POST" class="d-inline">
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

    <!-- Tampilkan pagination control -->
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
@endsection
