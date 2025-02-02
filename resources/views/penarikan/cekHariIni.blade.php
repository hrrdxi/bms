@extends('layouts.main')

@section('content')

<div class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="text-dark mb-0 fw-semibold">Penarikan Hari Ini</h5>
                <span class="text-primary small fw-medium">
                    {{ \Carbon\Carbon::now()->format('d F Y') }}
                </span>
            </div>
            
            <div class="row g-3 mb-4">
                <div class="col-lg-8">
                    <form action="{{ route('penarikan.cekHariIni') }}" method="GET">
                        <div class="input-group">
                            <!-- Input Pencarian -->
                            <input type="text" 
                                   class="form-control bg-light border-primary text-dark" 
                                   name="search" 
                                   placeholder="Cari data penarikan..." 
                                   value="{{ request('search') }}">
                                   
                            <!-- Tombol Cari -->
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>
            
                            <!-- Tombol Reset -->
                            @if(request('search'))
                                <a href="{{ route('penarikan.cekHariIni') }}" class="btn btn-danger ms-2">
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

            @if($penarikans->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fas fa-inbox fa-2x mb-3"></i>
                    <p class="mb-0">
                        @if(request('search'))
                            Tidak ditemukan data untuk pencarian "{{ request('search') }}"
                        @else
                            Belum ada data penarikan untuk hari ini
                        @endif
                    </p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="text-muted">
                                <th class="ps-0">No</th>
                                <th>ID Penarikan</th>
                                <th>Nama Nasabah</th>
                                <th>Kelas</th>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                                <th class="text-end pe-0">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penarikans as $penarikan)
                                <tr>
                                    <td class="ps-0">{{ $penarikans->firstItem() + $loop->index }}</td>
                                    <td class="text-primary fw-medium">{{ $penarikan->id_penarikan }}</td>
                                    <td>{{ $penarikan->nama_nasabah }}</td>
                                    <td>{{ $penarikan->kelas }}</td>
                                    <td>{{ $penarikan->keterangan_penarikan }}</td>
                                    <td class="text-muted">{{ \Carbon\Carbon::parse($penarikan->tanggal_penarikan)->format('d F Y') }}</td>
                                    <td class="text-end pe-0 fw-medium">
                                        Rp {{ number_format($penarikan->jumlah_penarikan, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @if($penarikans->isNotEmpty())
                            <tfoot>
                                <tr class="border-top">
                                    <td colspan="6" class="ps-0 text-muted fw-medium">Total Penarikan</td>
                                    <td class="text-end pe-0 fw-semibold">
                                        Rp {{ number_format($penarikans->sum('jumlah_penarikan'), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <small class="text-muted">
                        Menampilkan {{ $penarikans->firstItem() }}-{{ $penarikans->lastItem() }}
                        dari {{ $penarikans->total() }} data
                    </small>
                    {{ $penarikans->links() }}
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