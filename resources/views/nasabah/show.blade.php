@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-header bg-white shadow-sm">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center py-2">
                <div>
                    <h4 class="m-0 text-primary font-weight-bold">
                        <i class="fas fa-user-circle me-2"></i>Profil Nasabah
                    </h4>
                </div>
                <div>
                    <a href="{{ route('nasabah.download-card', $nasabah->id) }}" 
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-id-card me-2"></i>Download Kartu Identitas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid py-4">
            <div class="row">
                <!-- Left Column - Profile & QR -->
                <div class="col-md-4">
                    <!-- Profile Card -->
                    <div class="card card-profile shadow-sm mb-4">
                        <div class="card-header bg-gradient-primary text-white p-3">
                            <div class="text-center">
                                <h5 class="mb-0">Kartu Identitas Digital</h5>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="position-relative">
                                @if($nasabah->foto_kartu_pelajar)
                                    <div class="ratio ratio-4x3">
                                        <img src="{{ asset('storage/' . $nasabah->foto_kartu_pelajar) }}" 
                                             alt="Foto Kartu Pelajar"
                                             class="card-img-top object-fit-cover hover-zoom">
                                    </div>
                                @else
                                    <div class="text-center py-5 bg-light">
                                        <i class="fas fa-user-circle fa-5x text-muted"></i>
                                        <p class="mt-3 text-muted small">Foto tidak tersedia</p>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- QR Code -->
                            <div class="text-center p-4 border-top">
                                <div id="qrcode" class="d-inline-block p-2 bg-white rounded shadow-sm"></div>
                                <p class="text-muted small mt-2">
                                    <i class="fas fa-qrcode me-1"></i>
                                    Scan untuk verifikasi identitas
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Saldo Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body text-center">
                            <h6 class="text-muted mb-2">Total Saldo</h6>
                            <h3 class="text-success mb-0">
                                Rp {{ number_format($nasabah->saldo, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Details & Transactions -->
                <div class="col-md-8">
                    <!-- Personal Information -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                Informasi Pribadi
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="info-group bg-gray-50 p-3 rounded">
                                        <label class="text-gray-500 text-sm mb-1">ID Nasabah</label>
                                        <p class="mb-0 font-medium">{{ $nasabah->id_nasabah }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-group bg-gray-50 p-3 rounded">
                                        <label class="text-gray-500 text-sm mb-1">Nama Lengkap</label>
                                        <p class="mb-0 font-medium">{{ $nasabah->nama }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-group bg-gray-50 p-3 rounded">
                                        <label class="text-gray-500 text-sm mb-1">NIS</label>
                                        <p class="mb-0 font-medium">{{ $nasabah->no_identitas }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-group bg-gray-50 p-3 rounded">
                                        <label class="text-gray-500 text-sm mb-1">Kelas</label>
                                        <p class="mb-0 font-medium">{{ $nasabah->kelas }} {{ $nasabah->jurusan }} {{ $nasabah->angka_kelas }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-group bg-gray-50 p-3 rounded">
                                        <label class="text-gray-500 text-sm mb-1">Jenis Kelamin</label>
                                        <p class="mb-0 font-medium">{{ $nasabah->jenis_kelamin }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-group bg-gray-50 p-3 rounded">
                                        <label class="text-gray-500 text-sm mb-1">No. Telepon</label>
                                        <p class="mb-0 font-medium">{{ $nasabah->no_telepon }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-group bg-gray-50 p-3 rounded">
                                        <label class="text-gray-500 text-sm mb-1">Jenis Tabungan</label>
                                        <p class="mb-0 font-medium">{{ $nasabah->jenis_tabungan }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-group bg-gray-50 p-3 rounded">
                                        <label class="text-gray-500 text-sm mb-1">Tempat, Tanggal Lahir</label>
                                        <p class="mb-0 font-medium">
                                            {{ $nasabah->tempat_lahir }}, 
                                            {{ \Carbon\Carbon::parse($nasabah->tanggal_lahir)->format('d F Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction History -->
                    <div class="row">
                        <!-- Withdrawals -->
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-arrow-up text-danger me-2"></i>
                                        Riwayat Penarikan
                                    </h6>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive" style="height: 300px;">
                                        <table class="table table-hover mb-0">
                                            <thead class="bg-light sticky-top">
                                                <tr>
                                                    <th class="px-3">Tanggal</th>
                                                    <th class="text-end px-3">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($nasabah->penarikan as $penarikan)
                                                    <tr>
                                                        <td class="px-3">
                                                            {{ \Carbon\Carbon::parse($penarikan->tanggal_penarikan)->format('d M Y') }}
                                                        </td>
                                                        <td class="text-end px-3 text-danger">
                                                            - Rp {{ number_format($penarikan->jumlah_penarikan, 0, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="2" class="text-center text-muted py-3">
                                                            Belum ada data penarikan
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Deposits -->
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-arrow-down text-success me-2"></i>
                                        Riwayat Setoran
                                    </h6>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive" style="height: 300px;">
                                        <table class="table table-hover mb-0">
                                            <thead class="bg-light sticky-top">
                                                <tr>
                                                    <th class="px-3">Tanggal</th>
                                                    <th class="text-end px-3">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($nasabah->setorans as $setoran)
                                                    <tr>
                                                        <td class="px-3">
                                                            {{ \Carbon\Carbon::parse($setoran->tanggal_transaksi)->format('d M Y') }}
                                                        </td>
                                                        <td class="text-end px-3 text-success">
                                                            + Rp {{ number_format($setoran->jumlah_setoran, 0, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="2" class="text-center text-muted py-3">
                                                            Belum ada data setoran
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .content-wrapper {
        margin: 0; /* Hilangkan margin kiri */
        padding-left: 0;
        transition: margin-left 0.3s ease-in-out;
    }

    .card-profile .ratio {
        overflow: hidden;
        border-radius: 0;
    }

    .hover-zoom {
        transition: transform 0.3s ease;
    }

    .hover-zoom:hover {
        transform: scale(1.05);
    }

    .info-group {
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .table-responsive::-webkit-scrollbar {
        width: 6px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background-color: #dee2e6;
        border-radius: 3px;
    }

    .bg-gradient-primary {
        background: linear-gradient(45deg, #4e73df, #224abe);
    }

    .card {
        border: none;
        border-radius: 0.5rem;
    }

    .card-header {
        border-top-left-radius: 0.5rem !important;
        border-top-right-radius: 0.5rem !important;
    }

    .fw-medium {
        font-weight: 500;
    }
</style>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new QRCode(document.getElementById("qrcode"), {
            text: "{{ route('nasabah.verify', $nasabah->id) }}",
            width: 128,
            height: 128,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    });
</script>   
@endpush
@endsection