@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="content">
    <!-- Welcome Header -->
    <div class="card main-header mb-4">
        <div class="card-body text-center position-relative overflow-hidden">
            <div class="header-bg"></div>
            <div class="position-relative">
                <h1 class="display-4 fw-bold text-gradient mb-3">Selamat Datang!</h1>
                <p class="lead mb-2">
                    <span class="fw-semibold">Administrator</span> Mini Bank Amaliah
                </p>
                <p class="text-muted">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</p>
            </div>
        </div>
    </div>

    <!-- Financial Overview Cards -->
    <div class="row g-4 mb-4">
        <!-- Daily Balance -->
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Setoran Hari Ini</p>
                            <h3 class="mb-0">Rp {{ number_format($totalSetoranHariIni ?? 0, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-container bg-primary-subtle">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>
                    <div class="mt-3 progress-container">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-primary" 
                                style="width: {{ (($totalSetoranHariIni ?? 0) / max(($totalSetoranHariIni ?? 0) + ($totalPenarikanHariIni ?? 0), 1)) * 100 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daily Withdrawals -->
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Penarikan Hari Ini</p>
                            <h3 class="mb-0">Rp {{ number_format($totalPenarikanHariIni ?? 0, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-container bg-danger-subtle">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                    <div class="mt-3 progress-container">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-danger" 
                                style="width: {{ (($totalPenarikanHariIni ?? 0) / max(($totalSetoranHariIni ?? 0) + ($totalPenarikanHariIni ?? 0), 1)) * 100 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Total -->
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Total Bulanan</p>
                            <h3 class="mb-0">Rp {{ number_format($totalSetoranBulanan ?? 0, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-container bg-success-subtle">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                    </div>
                    <div class="mt-3 progress-container">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-success" 
                                style="width: {{ (($totalSetoranBulanan ?? 0) / max(($totalSetoranBulanan ?? 0) + ($totalPenarikanBulanan ?? 0), 1)) * 100 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Final Balance -->
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Saldo Akhir</p>
                            <h3 class="mb-0">Rp {{ number_format($saldoAkhir ?? 0, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-container bg-info-subtle">
                            <i class="bi bi-piggy-bank"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge {{ ($saldoAkhir ?? 0) >= 0 ? 'bg-success' : 'bg-danger' }}">
                            <i class="bi {{ ($saldoAkhir ?? 0) >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                            {{ ($saldoAkhir ?? 0) >= 0 ? 'Positif' : 'Negatif' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Info -->
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Aksi Cepat</h4>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ url('setoran') }}" class="quick-action-card">
                                <i class="bi bi-plus-circle"></i>
                                <span>Setoran Baru</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ url('penarikan') }}" class="quick-action-card">
                                <i class="bi bi-arrow-left-right"></i>
                                <span>Penarikan</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ url('data-lain') }}" class="quick-action-card">
                                <i class="bi bi-file-earmark-text"></i>
                                <span>Laporan</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Informasi</h4>
                    <div class="info-item">
                        <i class="bi bi-info-circle text-primary"></i>
                        <span>Sistem diperbarui setiap hari pukul 00:00 WIB</span>
                    </div>
                    <div class="info-item mt-3">
                        <i class="bi bi-shield-check text-success"></i>
                        <span>Data tersimpan dengan aman</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* CSS sudah dirapikan */
:root {
    --primary-gradient: linear-gradient(135deg, #FF5733 0%, #FF8C69 100%);
}

.text-gradient {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.main-header {
    border: none;
    background: white;
    overflow: hidden;
}

.header-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 100%;
    background: linear-gradient(135deg, rgba(255, 87, 51, 0.1) 0%, rgba(255, 140, 105, 0.1) 100%);
    transform: skewY(-6deg);
    transform-origin: top left;
}

.stat-card {
    border: none;
    background: white;
    transition: transform 0.3s ease, box-shadow 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.icon-container {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-container i {
    font-size: 1.5rem;
}

.progress-container {
    padding: 0.5rem 0;
}

.quick-action-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 12px;
    text-decoration: none;
    color: #495057;
    transition: all 0.3s ease;
}

.quick-action-card:hover {
    background: var(--primary-gradient);
    color: white;
    transform: translateY(-3px);
}

.quick-action-card i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 0;
}

.info-item i {
    font-size: 1.25rem;
}

@media (max-width: 768px) {
    .row.g-4 {
        margin: 0 -0.5rem;
    }
    .col-md-3 {
        padding: 0 0.5rem;
    }
}
</style>
@endsection
