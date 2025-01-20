<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class SetoranController extends Controller
{
    public function index()
    {
        $setorans = Setoran::with('nasabah')->paginate(8);
        return view('setoran', compact('setorans'));
    }

    public function create()
    {
        $nasabahs = Nasabah::all();
        return view('setoran.create', compact('nasabahs'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id',
            'nama_nasabah' => 'required',
            'id_nasabah' => 'required',
            'kelas' => 'required',
            'tanggal_transaksi' => 'required|date',
            'jumlah_setoran' => 'required|numeric',
        ]);
    
        // Mendapatkan tanggal dan waktu transaksi sesuai zona waktu Asia/Jakarta (WIB)
        $tanggal = \Carbon\Carbon::parse($request->tanggal_transaksi, 'Asia/Jakarta');
        $jam_sekarang = \Carbon\Carbon::now('Asia/Jakarta')->format('Hi');
        $tanggal_transaksi = $tanggal->format('dmy');
        $prefix = 'ST-' . $jam_sekarang . $tanggal_transaksi;
        $count = Setoran::whereDate('tanggal_transaksi', $tanggal->toDateString())->count() + 1;
        $id_setoran = $prefix . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    
        // Simpan setoran
        $setoran = Setoran::create([
            'nasabah_id' => $request->nasabah_id,
            'id_setoran' => $id_setoran,
            'nama_nasabah' => $request->nama_nasabah,
            'id_nasabah' => $request->id_nasabah,
            'kelas' => $request->kelas,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'jumlah_setoran' => $request->jumlah_setoran,
        ]);
    
        return redirect()->route('setoran.index')
            ->with('success', 'Setoran berhasil ditambahkan dengan ID: ' . $id_setoran)
            ->with('last_setoran_id', $setoran->id);
    }

    public function edit(Setoran $setoran)
    {
        return view('setoran.edit', compact('setoran'));
    }

    public function update(Request $request, Setoran $setoran)
    {
        $request->validate([
            'id_setoran' => 'required|unique:setorans,id_setoran,' . $setoran->id,
            'nama_nasabah' => 'required',
            'id_nasabah' => 'required',
            'kelas' => 'required',
            'tanggal_transaksi' => 'required|date',
            'jumlah_setoran' => 'required|numeric',
        ]);

        $setoran->update($request->all());
        return redirect()->route('setoran.index')->with('success', 'Setoran berhasil diperbarui.');
    }

    public function destroy(Setoran $setoran)
    {
        $setoran->delete();
        return redirect()->route('setoran.index')->with('success', 'Setoran berhasil dihapus.');
    }

    public function downloadSlip($id)
    {
        $setoran = Setoran::findOrFail($id);
        $pdf = PDF::loadView('setoran.slip', compact('setoran'));
        return $pdf->download('slip-setoran-' . $setoran->id_setoran . '.pdf');
    }

    public function printSlip($id)
    {
        $setoran = Setoran::findOrFail($id);
        $pdf = PDF::loadView('setoran.slip', compact('setoran'));
        return $pdf->stream('slip-setoran-' . $setoran->id_setoran . '.pdf');
    }
}