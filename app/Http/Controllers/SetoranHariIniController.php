<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use Illuminate\Http\Request;

class SetoranHariIniController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $setorans = Setoran::whereDate('tanggal_transaksi', $today)->paginate(8);

        return view('setoran.cekHariIni', compact('setorans'));
    }
}
