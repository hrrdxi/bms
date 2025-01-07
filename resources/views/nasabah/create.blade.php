@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Nasabah</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('nasabah.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>

        <div class="mb-3">
            <label for="foto_kartu_pelajar" class="form-label">Foto Kartu Pelajar</label>
            <input type="file" class="form-control" id="foto_kartu_pelajar" name="foto_kartu_pelajar" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label for="no_identitas" class="form-label">Nomor Identitas (NIS)</label>
            <input type="text" class="form-control" id="no_identitas" name="no_identitas" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki_laki" value="Laki-laki" required>
                    <label class="form-check-label" for="laki_laki">Laki-laki</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" required>
                    <label class="form-check-label" for="perempuan">Perempuan</label>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
        </div>

        <div class="mb-3">
            <label for="no_telepon" class="form-label">No Telepon</label>
            <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
        </div>

        <div class="mb-3">
            <label for="kelas" class="form-label">Kelas</label>
            <select class="form-control" id="kelas" name="kelas" required>
                <option value="" disabled selected>Pilih Kelas</option>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="jurusan" class="form-label">Jurusan</label>
            <select class="form-control" id="jurusan" name="jurusan" required>
                <option value="" disabled selected>Pilih Jurusan</option>
                <option value="PPLG">PPLG</option>
                <option value="AN">AN</option>
                <option value="TJKT">TJKT</option>
                <option value="DKV">DKV</option>
                <option value="LPS">LPS</option>
                <option value="BR">BR</option>
                <option value="DPB">DPB</option>
                <option value="MP">MP</option>
                <option value="AKL">AKL</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="angka_kelas" class="form-label">Angka Kelas</label>
            <select class="form-control" id="angka_kelas" name="angka_kelas" required>
                <option value="" disabled selected>Pilih Angka Kelas</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="Tidak Ada">Tidak Ada</option>
            </select>
        </div>
         <div class="mb-3">
            <label for="saldo" class="form-label">Saldo Awal</label>
            <input type="number" class="form-control" id="saldo" name="saldo" value="0" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
