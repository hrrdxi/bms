@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Nasabah</h1>

    <!-- Menampilkan error validasi -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('nasabah.update', $nasabah->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- ID Nasabah -->
        <div class="form-group">
            <label>ID Nasabah</label>
            <input type="text" name="id_nasabah" class="form-control" value="{{ old('id_nasabah', $nasabah->id_nasabah) }}" required>
        </div>

        <!-- Nama -->
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $nasabah->nama) }}" required>
        </div>

        <!-- Jenis Kelamin -->
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="Laki-laki" {{ old('jenis_kelamin', $nasabah->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $nasabah->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <!-- Tempat dan Tanggal Lahir -->
        <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $nasabah->tempat_lahir) }}" required>
        </div>
        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $nasabah->tanggal_lahir) }}" required>
        </div>

        <!-- No Telepon -->
        <div class="form-group">
            <label>No Telepon</label>
            <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $nasabah->no_telepon) }}" required>
        </div>

        <!-- Kelas -->
        <div class="form-group">
            <label>Kelas</label>
            <input type="text" name="kelas" class="form-control" value="{{ old('kelas', $nasabah->kelas) }}" required>
        </div>

        <!-- Jurusan -->
        <div class="form-group">
            <label>Jurusan</label>
            <select name="jurusan" class="form-control" required>
                <option value="" disabled>Pilih Jurusan</option>
                <option value="PPLG" {{ old('jurusan', $nasabah->jurusan) == 'PPLG' ? 'selected' : '' }}>PPLG</option>
                <option value="AN" {{ old('jurusan', $nasabah->jurusan) == 'AN' ? 'selected' : '' }}>AN</option>
                <option value="TJKT" {{ old('jurusan', $nasabah->jurusan) == 'TJKT' ? 'selected' : '' }}>TJKT</option>
                <option value="DKV" {{ old('jurusan', $nasabah->jurusan) == 'DKV' ? 'selected' : '' }}>DKV</option>
                <option value="AKL" {{ old('jurusan', $nasabah->jurusan) == 'AKL' ? 'selected' : '' }}>AKL</option>
                <option value="BR" {{ old('jurusan', $nasabah->jurusan) == 'BR' ? 'selected' : '' }}>BR</option>
                <option value="LPS" {{ old('jurusan', $nasabah->jurusan) == 'LPS' ? 'selected' : '' }}>LPS</option>
                <option value="DPB" {{ old('jurusan', $nasabah->jurusan) == 'DPB' ? 'selected' : '' }}>DPB</option>
                <option value="MP" {{ old('jurusan', $nasabah->jurusan) == 'MP' ? 'selected' : '' }}>MP</option>
            </select>
        </div>

        <!-- Saldo -->
        <div class="form-group">
            <label>Saldo</label>
            <input type="number" name="saldo" class="form-control" value="{{ old('saldo', $nasabah->saldo) }}" required>
        </div>

        <!-- Foto Kartu Pelajar (Opsional) -->
        <div class="form-group">
            <label>Foto Kartu Pelajar (Opsional)</label>
            <input type="file" name="foto_kartu_pelajar" class="form-control">
            @if ($nasabah->foto_kartu_pelajar)
                <small>Foto saat ini: <a href="{{ asset('storage/' . $nasabah->foto_kartu_pelajar) }}" target="_blank">Lihat Foto</a></small>
            @endif
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-warning">Update</button>
        <a href="{{ route('nasabah.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
