@extends('layouts.main')

@section('content')
<head>
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Setoran Masuk</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('setoran.store') }}" method="POST">
        @csrf
        <!-- Input field with Select2 for searchable dropdown -->
        <div class="form-group">
            <label>Pilih Nasabah</label>
            <select name="nasabah_id" id="nasabah_id" class="form-control" required onchange="populateNasabahData()">
                <option value="">-- Pilih Nasabah --</option>
                @foreach($nasabahs as $nasabah)
                    <option value="{{ $nasabah->id }}"
                        data-nama="{{ $nasabah->nama }}"
                        data-id-nasabah="{{ $nasabah->id_nasabah }}"
                        data-kelas="{{ $nasabah->kelas }}">
                        {{ $nasabah->id_nasabah }} - {{ $nasabah->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Automatically filled fields -->
        <div class="form-group">
            <label>Nama Nasabah</label>
            <input type="text" id="nama_nasabah" name="nama_nasabah" class="form-control" readonly required>
        </div>
        <div class="form-group">
            <label>ID Nasabah</label>
            <input type="text" id="id_nasabah" name="id_nasabah" class="form-control" readonly required>
        </div>
        <div class="form-group">
            <label>Kelas</label>
            <input type="text" id="kelas" name="kelas" class="form-control" readonly required>
        </div>
        
        <!-- Tanggal Transaksi dengan default nilai hari ini dan readonly -->
        <div class="form-group">
            <label>Tanggal Transaksi</label>
            <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" class="form-control" required readonly>
        </div>

        <div class="form-group">
            <label>Jumlah Setoran</label>
            <input type="number" name="jumlah_setoran" class="form-control" value="{{ old('jumlah_setoran') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('setoran.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
// JavaScript function to populate nama, id_nasabah, and kelas based on selected nasabah
function populateNasabahData() {
    var selectedNasabah = document.getElementById('nasabah_id');
    var namaNasabah = selectedNasabah.options[selectedNasabah.selectedIndex].getAttribute('data-nama');
    var idNasabah = selectedNasabah.options[selectedNasabah.selectedIndex].getAttribute('data-id-nasabah');
    var kelas = selectedNasabah.options[selectedNasabah.selectedIndex].getAttribute('data-kelas');

    document.getElementById('nama_nasabah').value = namaNasabah || '';
    document.getElementById('id_nasabah').value = idNasabah || '';
    document.getElementById('kelas').value = kelas || '';
    
    // Set default date to today and disable editing
    var today = new Date().toISOString().split('T')[0]; // Format as YYYY-MM-DD
    document.getElementById('tanggal_transaksi').value = today;
}

// Initialize Select2 for the nasabah dropdown (searchable select)
$(document).ready(function() {
    $('#nasabah_id').select2({
        placeholder: '-- Pilih Nasabah --',
        width: '100%',
        allowClear: true,  // Enable clearing the search input
        minimumInputLength: 2,  // Start search after typing 2 characters
        language: {
            noResults: function() {
                return "Tidak ada hasil ditemukan";  // Text for no results
            }
        }
    });
});
</script>
@endsection
