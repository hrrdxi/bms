<?php

namespace App\Http\Controllers;

use App\Models\Penarikan;
use Illuminate\Http\Request;

class PenarikanHariIniController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $penarikans = Penarikan::whereDate('tanggal_penarikan', $today)->paginate(8);

        return view('penarikan.cekHariIni', compact('penarikans'));
    }
}
