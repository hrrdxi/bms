<?php

namespace App\Http\Controllers;

use App\Models\Penarikan;
use Illuminate\Http\Request;

class PenarikanHariIniController extends Controller
{
    public function index(Request $request)
    {
        $today = now()->toDateString();
        
        $penarikans = Penarikan::whereDate('tanggal_penarikan', $today)
            ->when($request->search, function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('nama_nasabah', 'like', '%' . $request->search . '%')
                      ->orWhere('id_penarikan', 'like', '%' . $request->search . '%')
                      ->orWhere('kelas', 'like', '%' . $request->search . '%');
                });
            })
            ->paginate(8)
            ->withQueryString();
        
        return view('penarikan.cekHariIni', compact('penarikans'));
    }
}