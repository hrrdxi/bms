@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Manajemen Saldo Nasabah</h5>
                </div>
                <div class="card-body">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Form Cek Saldo -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Cek Saldo Nasabah</h6>
                                </div>
                                <div class="card-body">
                                    <form id="cekSaldoForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="nasabah_id" class="form-label">Pilih Nasabah</label>
                                            <select name="nasabah_id" id="nasabah_id" class="form-control" required>
                                                <option value="" disabled selected>Pilih Nasabah</option>
                                                @foreach ($nasabahs as $nasabah)
                                                    <option value="{{ $nasabah->id }}">
                                                        {{ $nasabah->nama }} ({{ $nasabah->id_nasabah }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="nasabah_detail" class="mb-3 d-none">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <p class="mb-1"><strong>Nama:</strong> <span id="detail_nama"></span></p>
                                                    <p class="mb-1"><strong>ID Nasabah:</strong> <span id="detail_id"></span></p>
                                                    <p class="mb-1"><strong>Kelas:</strong> <span id="detail_kelas"></span></p>
                                                    <p class="mb-0"><strong>Saldo:</strong> <span id="detail_saldo"></span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Cek Saldo</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Tabel Riwayat Saldo -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Riwayat Saldo Nasabah</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>ID Nasabah</th>
                                                    <th>Nama</th>
                                                    <th>Kelas</th>
                                                    <th>Saldo Awal</th>
                                                    <th>Saldo Akhir</th>
                                                    <th>Update Terakhir</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($saldos as $index => $saldo)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $saldo->nasabah->id_nasabah }}</td>
                                                        <td>{{ $saldo->nasabah->nama }}</td>
                                                        <td>{{ $saldo->nasabah->kelas_jurusan }}</td>
                                                        <td>Rp {{ number_format($saldo->saldo_awal, 0, ',', '.') }}</td>
                                                        <td>Rp {{ number_format($saldo->saldo_akhir, 0, ',', '.') }}</td>
                                                        <td>{{ $saldo->updated_at->format('d/m/Y H:i') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $saldos->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle form submission for checking saldo
    $('#cekSaldoForm').on('submit', function(e) {
        e.preventDefault();

        const nasabahId = $('#nasabah_id').val();

        if (!nasabahId) {
            alert('Pilih nasabah terlebih dahulu!');
            return;
        }

        $.ajax({
            url: `/api/nasabah/${nasabahId}/saldo`,
            type: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    $('#detail_nama').text(response.data.nama);
                    $('#detail_id').text(response.data.id_nasabah);
                    $('#detail_kelas').text(response.data.kelas_jurusan);
                    $('#detail_saldo').text('Rp ' + new Intl.NumberFormat('id-ID').format(response.data.saldo_akhir));
                    $('#nasabah_detail').removeClass('d-none');
                } else {
                    alert(response.message || 'Gagal mendapatkan data saldo.');
                }
            },
            error: function() {
                alert('Terjadi kesalahan, silakan coba lagi.');
            }
        });
    });
});
</script>
@endpush
@endsection
