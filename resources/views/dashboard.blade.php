@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
@keyframes typing {
    0% { width: 0; }
    9% { width: 0; }      
    70% { width: 100%; }     
    85% { width: 100%; }     
    100% { width: 0; }       
}

@keyframes blink {
    0%, 100% { border-color: transparent; }
    50% { border-color: #007bff; }
}

.typing-animation {
    display: inline-block;
    overflow: hidden;
    white-space: nowrap;
    border-right: 3px solid #007bff;
    animation: typing 10s steps(105, end) infinite, blink 0.8s step-end infinite;
    animation-delay: 0s;
    font-size: 16px;
    color: #4CAF50;
}
</style>

<div class="content">
    <!-- Header Card -->
    <div class="card shadow-sm p-3 mb-4 bg-white rounded top-border" style="border-top: 5px solid #007bff;">
        <div class="card-body">
            <h4 class="card-title" style="color: #4A4A4A; font-size: 22px;">Selamat Datang <span class="text-danger">Administrator</span> di APLIKASI MINI BANK SEKOLAH</h4>
            <p class="card-text" style="font-size: 14px;">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
        </div>
    </div>

    <!-- Transaksi Hari Minggu -->
    <div class="card mb-4">
        <div class="card-header bg-light" style="background-color: #E0E0E0; color: #007bff;">
            <h5 style="font-size: 16px;"><i class="fas fa-dollar-sign"></i> Transaksi Mini Bank Minggu Ini</h5>
        </div>
        <div class="card-body">
            <div class="row d-flex justify-content-center">
                <div class="col-md-5 mb-3">
                    <div class="card shadow-sm" style="border-left: 5px solid #007bff; width: 100%;">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="text-truncate" style="max-width: 75%;">
                                <!-- Add typing animation class here -->
                                <h6 class="text-primary typing-animation" style="color: #4CAF50; font-size: 16px;">TABUNGAN MASUK</h6>
                                <p class="card-text" style="font-size: 16px;">Rp. 0</p>
                            </div>
                            <i class="fas fa-shopping-cart fa-2x text-muted"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <div class="card shadow-sm" style="border-left: 5px solid #007bff; width: 100%;">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="text-truncate" style="max-width: 75%;">
                                <!-- Add typing animation class here -->
                                <h6 class="text-primary typing-animation" style="color: #007bff; font-size: 16px;">PENARIKAN TABUNGAN</h6>
                                <p class="card-text" style="font-size: 16px;">Rp. 0</p>
                            </div>
                            <i class="fas fa-wallet fa-2x text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Bulan Maret -->
    <div class="card mb-4">
        <div class="card-header bg-light" style="background-color: #E0E0E0; color: #4CAF50;">
            <h5 style="font-size: 16px;"><i class="fas fa-calendar-alt"></i> Transaksi Mini Bank Bulan Ini</h5>
        </div>
        <div class="card-body">
            <div class="row d-flex justify-content-center">
                <div class="col-md-5 mb-3">
                    <div class="card shadow-sm" style="border-left: 5px solid #007bff; width: 100%;">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="text-truncate" style="max-width: 75%;">
                                <h6 class="text-primary typing-animation" style="color: #4CAF50; font-size: 16px;">TABUNGAN MASUK</h6>
                                <p class="card-text" style="font-size: 16px;">Rp. 0</p>
                            </div>
                            <i class="fas fa-shopping-cart fa-2x text-muted"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <div class="card shadow-sm" style="border-left: 5px solid #007bff; width: 100%;">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="text-truncate" style="max-width: 75%;">
                                <h6 class="text-primary typing-animation" style="color: #007bff; font-size: 16px;">PENARIKAN TABUNGAN</h6>
                                <p class="card-text" style="font-size: 16px;">Rp. 0</p>
                            </div>
                            <i class="fas fa-wallet fa-2x text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection