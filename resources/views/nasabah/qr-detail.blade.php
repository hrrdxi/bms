@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Nasabah</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">ID Nasabah</label>
                                <p class="fw-bold mb-0">{{ $nasabah->id_nasabah }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">Nama Lengkap</label>
                                <p class="fw-bold mb-0">{{ $nasabah->nama }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">Kelas</label>
                                <p class="fw-bold mb-0">{{ $nasabah->kelas }} {{ $nasabah->jurusan }} {{ $nasabah->angka_kelas }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">Jenis Kelamin</label>
                                <p class="fw-bold mb-0">{{ $nasabah->jenis_kelamin }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">No. Telepon</label>
                                <p class="fw-bold mb-0">{{ $nasabah->no_telepon }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">Status</label>
                                <p class="fw-bold mb-0">
                                    <span class="badge bg-success">Aktif</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection