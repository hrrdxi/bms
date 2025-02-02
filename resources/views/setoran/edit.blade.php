@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Setoran Masuk</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('setoran.update', $setoran->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>ID Setoran</label>
            <input type="text" name="id_setoran" class="form-control" value="{{ $setoran->id_setoran }}" required>
        </div>
        <div class="form-group">
            <label>Nama Nasabah</label>
            <input type="text" name="nama_nasabah" class="form-control" value="{{ $setoran->nama_nasabah }}" required>
        </div>
        <div class="form-group">
            <label>ID Nasabah</label>
            <input type="text" name="id_nasabah" class="form-control" value="{{ $setoran->id_nasabah }}" required>
        </div>
        <div class="form-group">
            <label>Kelas</label>
            <input type="text" name="kelas" class="form-control" value="{{ $setoran->kelas }}" required>
        </div>
        <div class="form-group">
            <label for="tanggal_transaksi">Tanggal Transaksi</label>
            <input type="date" id="tanggal_transaksi" name="tanggal_transaksi" 
                   value="{{ old('tanggal_transaksi', \Carbon\Carbon::now()->toDateString()) }}" 
                   class="form-control" readonly>
        </div>
        <div class="form-group">
            <label>Jumlah Setoran</label>
            <input type="number" name="jumlah_setoran" class="form-control" value="{{ $setoran->jumlah_setoran }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('setoran.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
