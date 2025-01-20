@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Data Lain</h1>
    <div class="row">
        <div class="col-md-4">
            <a href="{{ route('data-lain.mingguan') }}" class="btn btn-primary btn-lg btn-block">Data Mingguan</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('data-lain.bulanan') }}" class="btn btn-success btn-lg btn-block">Data Bulanan</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('data-lain.master') }}" class="btn btn-info btn-lg btn-block">Data Master</a>
        </div>
    </div>
</div>
@endsection
