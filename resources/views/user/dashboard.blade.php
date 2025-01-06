@extends('layouts.app')

@section('content')


<div class="content">
    <!-- Header Card -->
    <div class="card shadow-sm p-3 mb-4 bg-white rounded top-border" style="border-top: 5px solid #007bff;">
        <div class="card-body">
            <h4 class="card-title" style="color: #4A4A4A; font-size: 22px;">SELAMAT DATANG DI APLIKASI MINI BANK SEKOLAH</h4>
            <p class="card-text" style="font-size: 14px;">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
        </div>
    </div>

    <!-- Ringkasan Transaksi User -->
    <div class="card mb-4">
        <div class="card-header bg-light" style="background-color: #E0E0E0; color: #007bff;">
            <h5 style="font-size: 16px;"><i class="fas fa-dollar-sign"></i> Ringkasan Transaksi</h5>
        </div>
        <div class="card-body">
            <div class="row d-flex justify-content-center">
                <div class="col-md-5 mb-3">
                    <div class="card shadow-sm" style="border-left: 5px solid #007bff; width: 100%;">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="text-truncate" style="max-width: 75%;">
                                <h6 class="text-primary" style="color: #4CAF50; font-size: 16px;">Total Tabungan</h6>
                                <p class="card-text" style="font-size: 16px;">Rp. 0</p>
                            </div>
                            <i class="fas fa-wallet fa-2x text-muted"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <div class="card shadow-sm" style="border-left: 5px solid #007bff; width: 100%;">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="text-truncate" style="max-width: 75%;">
                                <h6 class="text-primary" style="color: #007bff; font-size: 16px;">Total Penarikan</h6>
                                <p class="card-text" style="font-size: 16px;">Rp. 0</p>
                            </div>
                            <i class="fas fa-shopping-cart fa-2x text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
