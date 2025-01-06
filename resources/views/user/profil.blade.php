@extends('layouts.app')

@section('content')
<div class="content">
    <div class="card shadow-sm p-3 mb-4 bg-white rounded top-border" style="border-top: 5px solid #007bff;">
        <div class="card-body">
            <h4 class="card-title" style="color: #4A4A4A; font-size: 22px;">Profil Saya</h4>
            <p class="card-text" style="font-size: 14px;">Informasi profil Anda:</p>
            
            <p class="card-text" style="font-size: 16px;"><strong>Nama:</strong> {{ auth()->user()->name }}</p>
            <p class="card-text" style="font-size: 16px;"><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p class="card-text" style="font-size: 16px;"><strong>Saldo:</strong> Rp. 0</p>

            <!-- Jika ingin menambah opsi ubah profil -->
            <a href="#" class="btn btn-primary mt-3">Edit Profil</a>
        </div>
    </div>
</div>
@endsection
