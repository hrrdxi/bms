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

        <!-- Input field for nasabah search -->
        <div class="form-group">
            <label>Cari Nasabah</label>
            <div class="input-group">
                <input type="text" id="search_nasabah" class="form-control" placeholder="Masukkan ID atau nama nasabah..." autocomplete="off">
                <input type="hidden" name="nasabah_id" id="nasabah_id" required>
            </div>
            <div id="search_results" class="list-group mt-2" style="position: absolute; z-index: 1000; width: 95%;"></div>
        </div>

        <!-- Automatically filled fields -->
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
            <input type="date" name="tanggal_penarikan" id="tanggal_penarikan" class="form-control" required readonly>
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
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search_nasabah');
    const searchResults = document.getElementById('search_results');
    let timeoutId = null;

    // Set default date
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal_penarikan').value = today;

    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        const query = this.value;

        if (query.length < 2) {
            searchResults.innerHTML = '';
            return;
        }

        timeoutId = setTimeout(() => {
            fetch(`/api/search-nasabah-penarikan?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    searchResults.innerHTML = '';

                    if (data.length === 0) {
                        searchResults.innerHTML = '<div class="list-group-item">Tidak ada hasil</div>';
                        return;
                    }

                    data.forEach(nasabah => {
                        const div = document.createElement('div');
                        div.className = 'list-group-item list-group-item-action';
                        div.innerHTML = `${nasabah.id_nasabah} - ${nasabah.nama}`;
                        div.addEventListener('click', () => {
                            document.getElementById('nasabah_id').value = nasabah.id;
                            document.getElementById('nama_nasabah').value = nasabah.nama;
                            document.getElementById('kelas').value = nasabah.kelas;
                            searchInput.value = `${nasabah.id_nasabah} - ${nasabah.nama}`;
                            searchResults.innerHTML = '';
                        });
                        searchResults.appendChild(div);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    searchResults.innerHTML = '<div class="list-group-item text-danger">Terjadi kesalahan</div>';
                });
        }, 300);
    });

    // Close search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.innerHTML = '';
        }
    });
});
</script>
@endsection
