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

    <form action="{{ route('nasabah.update', $nasabah->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" required value="{{ old('nama', $nasabah->nama) }}">
            @error('nama')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="foto_kartu_pelajar" class="form-label">Foto Kartu Pelajar</label>
            <input type="file" class="form-control @error('foto_kartu_pelajar') is-invalid @enderror" id="foto_kartu_pelajar" name="foto_kartu_pelajar" accept="image/*">
            @if ($nasabah->foto_kartu_pelajar)
                <div class="mt-2">
                    <small>Foto saat ini: <a href="{{ asset('storage/' . $nasabah->foto_kartu_pelajar) }}" target="_blank">Lihat Foto</a></small>
                </div>
            @endif
            @error('foto_kartu_pelajar')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="no_identitas" class="form-label">Nomor Identitas (NIS)</label>
            <input type="text" class="form-control @error('no_identitas') is-invalid @enderror" id="no_identitas" name="no_identitas" required value="{{ old('no_identitas', $nasabah->no_identitas) }}">
            @error('no_identitas')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <div>
                <div class="form-check">
                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="laki_laki" value="Laki-laki" {{ old('jenis_kelamin', $nasabah->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="laki_laki">Laki-laki</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" {{ old('jenis_kelamin', $nasabah->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="perempuan">Perempuan</label>
                </div>
                @error('jenis_kelamin')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" required value="{{ old('tempat_lahir', $nasabah->tempat_lahir) }}">
            @error('tempat_lahir')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" required value="{{ old('tanggal_lahir', $nasabah->tanggal_lahir) }}">
            @error('tanggal_lahir')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="no_telepon" class="form-label">No Telepon</label>
            <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon" name="no_telepon" required value="{{ old('no_telepon', $nasabah->no_telepon) }}">
            @error('no_telepon')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="jenis_tabungan" class="form-label">Jenis Tabungan</label>
            <select class="form-control @error('jenis_tabungan') is-invalid @enderror" id="jenis_tabungan" name="jenis_tabungan" required>
                <option value="" disabled>Pilih Jenis Tabungan</option>
                <option value="Wadiah" {{ old('jenis_tabungan', $nasabah->jenis_tabungan) == 'Wadiah' ? 'selected' : '' }}>Wadiah</option>
                <option value="Mudharabah" {{ old('jenis_tabungan', $nasabah->jenis_tabungan) == 'Mudharabah' ? 'selected' : '' }}>Mudharabah</option>
                <option value="Deposito Mudharabah" {{ old('jenis_tabungan', $nasabah->jenis_tabungan) == 'Deposito Mudharabah' ? 'selected' : '' }}>Deposito Mudharabah</option>
            </select>
            @error('jenis_tabungan')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="kelas_type" class="form-label">Tipe Kelas</label>
            <select class="form-control @error('kelas_type') is-invalid @enderror" id="kelas_type" name="kelas_type" required>
                <option value="regular" {{ (!$nasabah->jurusan) ? '' : 'selected' }}>Regular</option>
                <option value="order" {{ (!$nasabah->jurusan) ? 'selected' : '' }}>Order</option>
            </select>
            @error('kelas_type')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div id="regular_kelas_fields">
            <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <select class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas">
                    <option value="" disabled>Pilih Kelas</option>
                    <option value="X" {{ old('kelas', $nasabah->kelas) == 'X' ? 'selected' : '' }}>X</option>
                    <option value="XI" {{ old('kelas', $nasabah->kelas) == 'XI' ? 'selected' : '' }}>XI</option>
                    <option value="XII" {{ old('kelas', $nasabah->kelas) == 'XII' ? 'selected' : '' }}>XII</option>
                </select>
                @error('kelas')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="jurusan" class="form-label">Jurusan</label>
                <select class="form-control @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan">
                    <option value="" disabled>Pilih Jurusan</option>
                    <option value="PPLG" {{ old('jurusan', $nasabah->jurusan) == 'PPLG' ? 'selected' : '' }}>PPLG</option>
                    <option value="AN" {{ old('jurusan', $nasabah->jurusan) == 'AN' ? 'selected' : '' }}>AN</option>
                    <option value="TJKT" {{ old('jurusan', $nasabah->jurusan) == 'TJKT' ? 'selected' : '' }}>TJKT</option>
                    <option value="DKV" {{ old('jurusan', $nasabah->jurusan) == 'DKV' ? 'selected' : '' }}>DKV</option>
                    <option value="LPS" {{ old('jurusan', $nasabah->jurusan) == 'LPS' ? 'selected' : '' }}>LPS</option>
                    <option value="BR" {{ old('jurusan', $nasabah->jurusan) == 'BR' ? 'selected' : '' }}>BR</option>
                    <option value="DPB" {{ old('jurusan', $nasabah->jurusan) == 'DPB' ? 'selected' : '' }}>DPB</option>
                    <option value="MP" {{ old('jurusan', $nasabah->jurusan) == 'MP' ? 'selected' : '' }}>MP</option>
                    <option value="AKL" {{ old('jurusan', $nasabah->jurusan) == 'AKL' ? 'selected' : '' }}>AKL</option>
                </select>
                @error('jurusan')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="angka_kelas" class="form-label">Angka Kelas</label>
                <select class="form-control @error('angka_kelas') is-invalid @enderror" id="angka_kelas" name="angka_kelas">
                    <option value="" disabled>Pilih Angka Kelas</option>
                    <option value="1" {{ old('angka_kelas', $nasabah->angka_kelas) == '1' ? 'selected' : '' }}>1</option>
                    <option value="2" {{ old('angka_kelas', $nasabah->angka_kelas) == '2' ? 'selected' : '' }}>2</option>
                    <option value="3" {{ old('angka_kelas', $nasabah->angka_kelas) == '3' ? 'selected' : '' }}>3</option>
                    <option value="4" {{ old('angka_kelas', $nasabah->angka_kelas) == '4' ? 'selected' : '' }}>4</option>
                    <option value="5" {{ old('angka_kelas', $nasabah->angka_kelas) == '5' ? 'selected' : '' }}>5</option>
                    <option value="6" {{ old('angka_kelas', $nasabah->angka_kelas) == '6' ? 'selected' : '' }}>6</option>
                    <option value="Tidak Ada" {{ old('angka_kelas', $nasabah->angka_kelas) == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                </select>
                @error('angka_kelas')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div id="order_kelas_field" class="mb-3" style="display: none;">
            <label for="kelas_order" class="form-label">Kelas (Other)</label>
            <input type="text" class="form-control @error('kelas_order') is-invalid @enderror" id="kelas_order" name="kelas_order" value="{{ old('kelas_order', (!$nasabah->jurusan ? $nasabah->kelas : '')) }}">
            @error('kelas_order')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="saldo" class="form-label">Saldo</label>
            <input type="number" class="form-control @error('saldo') is-invalid @enderror" id="saldo" name="saldo" required value="{{ old('saldo', $nasabah->saldo) }}">
            @error('saldo')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-warning">Update</button>
        <a href="{{ route('nasabah.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kelasType = document.getElementById('kelas_type');
    const regularKelasFields = document.getElementById('regular_kelas_fields');
    const orderKelasField = document.getElementById('order_kelas_field');
    const kelasSelect = document.getElementById('kelas');
    const jurusanSelect = document.getElementById('jurusan');
    const angkaKelasSelect = document.getElementById('angka_kelas');
    const kelasOrderInput = document.getElementById('kelas_order');

    function toggleKelasFields() {
        if (kelasType.value === 'order') {
            regularKelasFields.style.display = 'none';
            orderKelasField.style.display = 'block';
            kelasOrderInput.required = true;
            kelasSelect.required = false;
            jurusanSelect.required = false;
            angkaKelasSelect.required = false;
        } else {
            regularKelasFields.style.display = 'block';
            orderKelasField.style.display = 'none';
            kelasOrderInput.required = false;
            kelasSelect.required = true;
            jurusanSelect.required = true;
            angkaKelasSelect.required = true;
        }
    }

    // Set initial state
    toggleKelasFields();

    // Add event listener for changes
    kelasType.addEventListener('change', toggleKelasFields);
});
</script>
@endsection