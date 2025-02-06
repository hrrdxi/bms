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
        $penarikans = Penarikan::paginate(10);
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

        $tanggal = \Carbon\Carbon::parse($request->tanggal_penarikan, 'Asia/Jakarta');
        $jam_sekarang = \Carbon\Carbon::now('Asia/Jakarta')->format('Hi');
        $tanggal_transaksi = $tanggal->format('dmy');
        $prefix = 'PN-' . $jam_sekarang . $tanggal_transaksi;
        $count = Penarikan::whereDate('tanggal_penarikan', $tanggal->toDateString())->count() + 1;
        $id_penarikan = $prefix . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        $penarikan = Penarikan::create(array_merge($validated, [
            'id_penarikan' => $id_penarikan,
            'amount' => $request->jumlah_penarikan,
        ]));

        return redirect()->route('penarikan.index')
            ->with('success', 'penarikan berhasil ditambahkan dengan ID: ' . $id_penarikan)
            ->with('last_penarikan_id', $penarikan->id);
    }

    public function edit(Penarikan $penarikan)
    {
        return view('penarikan.edit', compact('penarikan'));
    }

    public function update(Request $request, Penarikan $penarikan)
    {
        // Validasi input
        $request->validate([
            'id_penarikan' => 'required|unique:penarikans,id_penarikan,' . $penarikan->id,
            'nama_nasabah' => 'required',
            'kelas' => 'required',
            'keterangan_penarikan' => 'required',
            'jumlah_penarikan' => 'required|numeric|min:0',
        ]);

        $penarikan->update($request->all());

        return redirect()->route('penarikan.index')->with('success', 'Penarikan berhasil diperbarui.');
    }

    public function destroy(Penarikan $penarikan)
    {
        // Hapus penarikan
        $penarikan->delete();

        return redirect()->route('penarikan.index')->with('success', 'Penarikan berhasil dihapus.');
    }

    public function downloadSlip($id)
    {
        $penarikan = Penarikan::findOrFail($id);
        $pdf = PDF::loadView('penarikan.slip', compact('penarikan'));
        return $pdf->download('slip-penarikan-' . $penarikan->id_penarikan . '.pdf');
    }

    public function printSlip($id)
    {
        $penarikan = Penarikan::findOrFail($id);
        $pdf = PDF::loadView('penarikan.slip', compact('penarikan'));
        return $pdf->stream('slip-penarikan-' . $penarikan->id_penarikan . '.pdf');
    }

    public function searchAjax(Request $request)
    {
        $query = $request->get('query');
        
        // Log untuk debugging
        \Log::info('Search query for penarikan received: ' . $query);
        
        $nasabahs = Nasabah::where(function($q) use ($query) {
            $q->where('id_nasabah', 'like', "{$query}%")
              ->orWhere('id_nasabah', 'like', "%{$query}%")
              ->orWhere('nama', 'like', "%{$query}%");
        })
        ->select('id', 'id_nasabah', 'nama', 'kelas', 'jurusan', 'angka_kelas')
        ->limit(10)
        ->get();
        
        // Log hasil pencarian
        \Log::info('Search results for penarikan count: ' . $nasabahs->count());
        
        return response()->json($nasabahs);
    }
    public function search(Request $request)
    {
        $query = Penarikan::query();

        // Search by name or ID
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_nasabah', 'like', "%{$searchTerm}%")
                  ->orWhere('id_penarikan', 'like', "%{$searchTerm}%");
            });
        }

        $penarikans = $query->paginate(10);

        return view('penarikan', compact('penarikans'));
    }
}