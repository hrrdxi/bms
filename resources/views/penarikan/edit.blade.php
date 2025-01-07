@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Penarikan Uang</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penarikan.update', $penarikan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>ID Penarikan</label>
            <input type="text" name="id_penarikan" class="form-control" value="{{ $penarikan->id_penarikan }}" required>
        </div>
        <div class="form-group">
            <label>Nama Nasabah</label>
            <input type="text" name="nama_nasabah" class="form-control" value="{{ $penarikan->nama_nasabah }}" required>
        </div>
        <div class="form-group">
            <label>Kelas</label>
            <input type="text" name="kelas" class="form-control" value="{{ $penarikan->kelas }}" required>
        </div>
        <div class="form-group">
            <label>Keterangan Penarikan</label>
            <textarea name="keterangan_penarikan" class="form-control" required>{{ $penarikan->keterangan_penarikan }}</textarea>
        </div>
        <div class="form-group">
            <label>Tanggal Penarikan</label>
            <input type="date" name="tanggal_penarikan" class="form-control" value="{{ $penarikan->tanggal_penarikan }}" required>
        </div>
        <div class="form-group">
            <label>Jumlah Penarikan</label>
            <input type="number" name="jumlah_penarikan" class="form-control" value="{{ $penarikan->jumlah_penarikan }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('penarikan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
