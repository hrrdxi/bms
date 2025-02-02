<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use Illuminate\Http\Request;

class SetoranHariIniController extends Controller
{
    public function index(Request $request)
    {
        $today = now()->toDateString();
        
        $setorans = Setoran::whereDate('tanggal_transaksi', $today)
            ->when($request->search, function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('nama_nasabah', 'like', '%' . $request->search . '%')
                      ->orWhere('id_setoran', 'like', '%' . $request->search . '%')
                      ->orWhere('kelas', 'like', '%' . $request->search . '%');
                });
            })
            ->paginate(8)
            ->withQueryString();
        
        return view('setoran.cekHariIni', compact('setorans'));
    }
}