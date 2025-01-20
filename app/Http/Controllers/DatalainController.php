<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use App\Models\Penarikan;
use App\Models\Nasabah;
use Carbon\Carbon;

class DataLainController extends Controller
{
    public function index()
    {
        return view('datalain');
    }

    public function dataMingguan()
    {
        // Data Mingguan
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $setoranMingguan = Setoran::whereBetween('tanggal_transaksi', [$startOfWeek, $endOfWeek])->get();
        $penarikanMingguan = Penarikan::whereBetween('tanggal_penarikan', [$startOfWeek, $endOfWeek])->get();

        return view('data-lain.mingguan', compact('setoranMingguan', 'penarikanMingguan'));
    }

    public function dataBulanan()
    {
        // Data Bulanan
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $setoranBulanan = Setoran::whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])->get();
        $penarikanBulanan = Penarikan::whereBetween('tanggal_penarikan', [$startOfMonth, $endOfMonth])->get();

        return view('data-lain.bulanan', compact('setoranBulanan', 'penarikanBulanan'));
    }

    public function dataMaster()
    {
        // Data Master
        $nasabah = Nasabah::all();

        return view('data-lain.master', compact('nasabah'));
    }
}