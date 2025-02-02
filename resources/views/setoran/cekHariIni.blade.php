@extends('layouts.main')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="text-dark mb-0 fw-semibold">Setoran Hari Ini</h5>
                <span class="text-primary small fw-medium">
                    {{ \Carbon\Carbon::now()->format('d F Y') }}
                </span>
            </div>
            
            <!-- Search Form -->
            <div class="row g-3 mb-4">
                <div class="col-lg-8">
                    <form action="{{ route('setoran.cekHariIni') }}" method="GET">
                        <div class="input-group">
                            <!-- Input Pencarian -->
                            <input type="text" 
                                   class="form-control bg-light border-primary text-dark" 
                                   name="search" 
                                   placeholder="Cari data setoran..." 
                                   value="{{ request('search') }}">
                                   
                            <!-- Tombol Cari -->
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>
            
                            <!-- Tombol Reset -->
                            @if(request('search'))
                                <a href="{{ route('setoran.cekHariIni') }}" class="btn btn-danger ms-2">
                                    <i class="fas fa-times"></i> Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success bg-success bg-opacity-10 text-success border-0 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($setorans->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fas fa-inbox fa-2x mb-3"></i>
                    <p class="mb-0">
                        @if(request('search'))
                            Tidak ditemukan data untuk pencarian "{{ request('search') }}"
                        @else
                            Belum ada data setoran untuk hari ini
                        @endif
                    </p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="text-muted">
                                <th width="5%" class="ps-0">No</th>
                                <th width="20%">ID Setoran</th>
                                <th width="35%">Nama Nasabah</th>
                                <th width="15%">Kelas</th>
                                <th width="15%">Tanggal</th>
                                <th width="10%" class="text-end pe-0">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($setorans as $setoran)
                                <tr>
                                    <td class="ps-0">{{ $setorans->firstItem() + $loop->index }}</td>
                                    <td class="text-primary fw-medium">{{ $setoran->id_setoran }}</td>
                                    <td>{{ $setoran->nama_nasabah }}</td>
                                    <td>{{ $setoran->kelas }}</td>
                                    <td class="text-muted">{{ \Carbon\Carbon::parse($setoran->tanggal_setoran)->format('d F Y') }}</td>
                                    <td class="text-end pe-0 fw-medium">
                                        Rp {{ number_format($setoran->jumlah_setoran, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @if($setorans->isNotEmpty())
                            <tfoot>
                                <tr class="border-top">
                                    <td colspan="5" class="ps-0 text-muted fw-medium">Total Setoran</td>
                                    <td class="text-end pe-0 fw-semibold">
                                        Rp {{ number_format($setorans->sum('jumlah_setoran'), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <small class="text-muted">
                        Menampilkan {{ $setorans->firstItem() }}-{{ $setorans->lastItem() }}
                        dari {{ $setorans->total() }} data
                    </small>
                    {{ $setorans->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 12px;
    }
    
    .form-control:focus {
        border-color: #dee2e6;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.05);
    }
    
    .btn-outline-secondary {
        border-color: #dee2e6;
    }
    
    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
    }
    
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
        border-bottom-color: #f0f0f0;
    }
    
    .table > thead > tr > th {
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border-top: none;
        border-bottom: 1px solid #eee;
    }
    
    .pagination {
        margin-bottom: 0;
    }
    
    .page-link {
        border-radius: 4px;
        margin: 0 2px;
    }
    
    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }
        
        .table > :not(caption) > * > * {
            padding: 0.75rem 0.5rem;
        }
    }
</style>
@endpush