@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Data Master</h1>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID Nasabah</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nasabah as $data)
            <tr>
                <td>{{ $data->id_nasabah }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->kelas }}</td>
                <td>{{ $data->jurusan }}</td>
                <td>{{ number_format($data->saldo, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection