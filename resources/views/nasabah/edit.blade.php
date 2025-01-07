@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Nasabah</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('nasabah.update', $nasabah->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>ID Nasabah</label>
            <input type="text" name="id_nasabah" class="form-control" value="{{ old('id_nasabah', $nasabah->id_nasabah) }}" required>
        </div>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $nasabah->nama) }}" required>
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="Laki-laki" {{ $nasabah->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ $nasabah->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tempat Tanggal Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $nasabah->tempat_lahir) }}" required>
            <input type="date" name="tanggal_lahir" class="form-control mt-2" value="{{ old('tanggal_lahir', $nasabah->tanggal_lahir) }}" required>
        </div>
        <div class="form-group">
            <label>No Telepon</label>
            <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $nasabah->no_telepon) }}" required>
        </div>
        <div class="form-group">
            <label>Kelas</label>
            <input type="text" name="kelas" class="form-control" value="{{ old('kelas', $nasabah->kelas) }}" required>
        </div>
        
        <button type="submit" class="btn btn-warning">Update</button>
        <a href="{{ route('nasabah.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
