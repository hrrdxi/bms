@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

 <form action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-danger mt-3">
        <i class="bi bi-box-arrow-right"></i> Logout
    </button>
</form>

<div class="content">
    <div class="card main-header mb-4">
        <div class="card-body text-center position-relative overflow-hidden">
            <div class="header-bg"></div>
            <div class="position-relative">
                <h1 class="display-4 fw-bold text-gradient mb-3">Selamat Datang!</h1>
                <p class="lead mb-2">
                    <span class="fw-semibold">Administrator</span> Mini Bank Sekolah
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
                            <div class="progress-bar bg-primary" style="width: {{ (($totalSetoranHariIni ?? 0) / (($totalSetoranHariIni ?? 0) + ($totalPenarikanHariIni ?? 0) + 1)) * 100 }}%"></div>
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
                            <div class="progress-bar bg-danger" style="width: {{ (($totalPenarikanHariIni ?? 0) / (($totalSetoranHariIni ?? 0) + ($totalPenarikanHariIni ?? 0) + 1)) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Monthly Total -->
        <!-- (Lanjutkan dengan struktur lainnya) -->
    </div>
</div>
@endsection
