<!-- resources/views/nasabah/verify.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Nasabah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">Data Nasabah Terverifikasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>
                                Verifikasi berhasil pada {{ $verificationTime }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-success">Informasi Nasabah:</h6>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="35%">ID Nasabah</th>
                                        <td>: {{ $nasabah->id_nasabah }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama</th>
                                        <td>: {{ $nasabah->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kelas</th>
                                        <td>: {{ $nasabah->kelas }} {{ $nasabah->jurusan }} {{ $nasabah->angka_kelas }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>: {{ $nasabah->jenis_kelamin }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. Telepon</th>
                                        <td>: {{ $nasabah->no_telepon }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>