@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Penarikan Uang</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penarikan.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Pilih Nasabah</label>
            <select name="nasabah_id" id="nasabah_id" class="form-control" required onchange="populateNasabahData()">
                <option value="">-- Pilih Nasabah --</option>
                @foreach($nasabahs as $nasabah)
                    <option value="{{ $nasabah->id }}"
                        data-nama="{{ $nasabah->nama }}"
                        data-kelas="{{ $nasabah->kelas }}">
                        {{ $nasabah->id_nasabah }} - {{ $nasabah->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label>Nama Nasabah</label>
            <input type="text" id="nama_nasabah" name="nama_nasabah" class="form-control" readonly required>
        </div>

        <div class="form-group">
            <label>Kelas</label>
            <input type="text" id="kelas" name="kelas" class="form-control" readonly required>
        </div>

        <div class="form-group">
            <label>Keterangan Penarikan</label>
            <input type="text" name="keterangan_penarikan" class="form-control" value="{{ old('keterangan_penarikan') }}" required>
        </div>

        <div class="form-group">
            <label>Tanggal Penarikan</label>
            <input type="date" name="tanggal_penarikan" class="form-control" value="{{ old('tanggal_penarikan') }}" required>
        </div>

        <div class="form-group">
            <label>Jumlah Penarikan</label>
            <input type="number" name="jumlah_penarikan" class="form-control" value="{{ old('jumlah_penarikan') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('penarikan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    function populateNasabahData() {
        const selectedNasabah = document.getElementById('nasabah_id');
        const namaNasabah = selectedNasabah.options[selectedNasabah.selectedIndex].getAttribute('data-nama');
        const kelas = selectedNasabah.options[selectedNasabah.selectedIndex].getAttribute('data-kelas');

        document.getElementById('nama_nasabah').value = namaNasabah || '';
        document.getElementById('kelas').value = kelas || '';
    }
</script>
@endsection
