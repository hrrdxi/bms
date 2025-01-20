<?php

namespace App\Http\Controllers;

use App\Models\Penarikan;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PenarikanController extends Controller
{
    public function index()
    {
        $penarikans = Penarikan::paginate(8);
        return view('penarikan', compact('penarikans'));
    }

    public function create()
    {
        $nasabahs = Nasabah::all(); // Ambil semua nasabah untuk dropdown
        return view('penarikan.create', compact('nasabahs'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id',
            'nama_nasabah' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'keterangan_penarikan' => 'required|string|max:255',
            'tanggal_penarikan' => 'required|date',
            'jumlah_penarikan' => 'required|numeric|min:0',
        ]);
    
        // Mendapatkan tanggal penarikan
        $tanggal = \Carbon\Carbon::parse($request->tanggal_penarikan, 'Asia/Jakarta'); // Menggunakan waktu WIB
    
        // Format ID Penarikan: PN-HHMMDDMMYY (contoh: PN-1215041124)
        $jam_sekarang = \Carbon\Carbon::now('Asia/Jakarta')->format('Hi'); // Format HHMM (Jam dan Menit) sesuai WIB
        $tanggal_transaksi = $tanggal->format('dmy'); // Format ddmmyy (misal: 041124)
    
        // Kombinasi untuk ID Penarikan
        $prefix = 'PN-' . $jam_sekarang . $tanggal_transaksi; // Menghasilkan ID seperti PN-1215041124
    
        // Menghitung jumlah penarikan yang ada pada tanggal tersebut
        $count = Penarikan::whereDate('tanggal_penarikan', $tanggal->toDateString())->count() + 1;
    
        // Membuat ID Penarikan dengan format: PN-HHMMDDMMYY-001
        $id_penarikan = $prefix . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    
        // Simpan penarikan baru dengan ID Penarikan yang sudah di-generate
$penarikan = Penarikan::create(array_merge($validated, [
    'id_penarikan' => $id_penarikan,
    'amount' => $request->jumlah_penarikan, // Isi amount sesuai jumlah penarikan
]));

session(['last_penarikan_id' => $penarikan->id]);
    

        // Redirect dengan pesan sukses
        return redirect()->route('penarikan.index')->with('success', 'Penarikan berhasil ditambahkan dengan ID: ' . $id_penarikan);
    }
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penarikan $penarikan)
    {
        return view('penarikan.edit', compact('penarikan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penarikan $penarikan)
    {
        // Validate request data
        $request->validate([
            'id_penarikan' => 'required|unique:penarikans,id_penarikan,' . $penarikan->id,
            'nama_nasabah' => 'required',
            'kelas' => 'required',
            'keterangan_penarikan' => 'required',
            'tanggal_penarikan' => 'required|date',
            'jumlah_penarikan' => 'required|numeric',
        ]);

        // Update penarikan
        $penarikan->update($request->all());

        return redirect()->route('penarikan.index')->with('success', 'Penarikan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penarikan $penarikan)
    {
        // Delete penarikan
        $penarikan->delete();

        return redirect()->route('penarikan.index')->with('success', 'Penarikan berhasil dihapus.');
    }

    public function downloadSlip($id)
    {
        $penarikan = Penarikan::findOrFail($id);
        $pdf = PDF::loadView('penarikan.slip', compact('penarikan'));
        return $pdf->download("slip-penarikan-{$penarikan->id_penarikan}.pdf");
    }

    public function printSlip($id)
    {
        $penarikan = Penarikan::findOrFail($id);
        $pdf = PDF::loadView('penarikan.slip', compact('penarikan'));
        return $pdf->stream('slip-penarikan-' . $penarikan->id_penarikan . '.pdf');
    }
    
}

