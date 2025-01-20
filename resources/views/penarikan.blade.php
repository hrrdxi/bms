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
    </style>
</head>

    <h1 class="h3 mb-4 text-gray-800">Penarikan Uang</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>

    <!-- Popup for printing slip after successful creation -->
    <div class="popup-overlay" id="printPopup">
        <div class="popup-content">
            <h4 class="text-center mb-3">Penarikan Berhasil Ditambahkan!</h4>
            <p class="text-center mb-4">Apakah Anda ingin mencetak slip penarikan sekarang?</p>
            <div class="popup-buttons">
                <a href="{{ route('penarikan.print-slip', ['id' => session('last_penarikan_id')]) }}" 
                   class="btn btn-primary">
                    <i class="fas fa-print me-1"></i> Cetak Slip
                </a>
                <button class="btn btn-secondary" 
                        onclick="document.getElementById('printPopup').style.display='none'">
                    Nanti Saja
                </button>
            </div>
        </div>
    </div>
@endif

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <div class="mb-2">
            <a href="{{ route('penarikan.create') }}" class="btn btn-success btn-action mb-2">
                <i class="fas fa-plus"></i> Tambah Penarikan Uang
            </a>
            <a href="{{ route('penarikan.cekHariIni') }}" class="btn btn-primary btn-action mb-2">
                <i class="fas fa-calendar-day"></i> Cek Hari Ini
            </a>
            <a href="{{ route('penarikan.cekSemua') }}" class="btn btn-danger btn-action mb-2">
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
                            <a href="{{ route('penarikan.download-slip', $penarikan->id) }}" 
                                class="btn btn-info btn-sm btn-action">
                                 <i class="fas fa-download"></i> Slip
                             </a>
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
<script>
    // Show print popup if success message exists
    @if(session('success') && session('last_penarikan_id'))
        document.getElementById('printPopup').style.display = 'block';
    @endif
</script>
@endsection
