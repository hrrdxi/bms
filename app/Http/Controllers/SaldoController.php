<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\Nasabah;
use App\Models\Setoran;
use App\Models\Penarikan;
use Illuminate\Http\Request;

class SaldoController extends Controller
{
    /**
     * Menampilkan halaman saldo dan daftar saldo nasabah dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        // Menangani pencarian berdasarkan nama atau ID nasabah
        $search = $request->get('search');

        // Ambil data nasabah dan saldo, dengan relasi setoran dan penarikan
        $nasabahs = Nasabah::when($search, function($query, $search) {
            return $query->where('nama', 'like', "%$search%")
                         ->orWhere('id_nasabah', 'like', "%$search%");
        })->get();

        $saldos = Saldo::with('nasabah')
                       ->when($search, function($query, $search) {
                           return $query->whereHas('nasabah', function($q) use ($search) {
                               $q->where('nama', 'like', "%$search%")
                                 ->orWhere('id_nasabah', 'like', "%$search%");
                           });
                       })
                       ->paginate(10); // Paginasi saldo nasabah

        return view('saldo', compact('nasabahs', 'saldos', 'search'));
    }

    /**
     * Cek saldo nasabah atau menambahkan saldo awal otomatis.
     */
    public function cekSaldoNasabah(Request $request)
    {
        $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id',
        ]);

        $nasabah = Nasabah::findOrFail($request->nasabah_id);

        $saldo = Saldo::where('nasabah_id', $nasabah->id)->first();

        if (!$saldo) {
            $saldo = Saldo::create([
                'nasabah_id' => $nasabah->id,
                'saldo_awal' => 10000,
                'saldo_akhir' => 10000,
            ]);

            return redirect()->route('saldo.index')->with('success', 'Saldo awal sebesar 10.000 berhasil ditambahkan untuk nasabah: ' . $nasabah->nama);
        }

        return redirect()->route('saldo.index')->with('success', 'Nasabah ' . $nasabah->nama . ' sudah memiliki saldo.');
    }

    /**
     * Memperbarui saldo akhir nasabah setelah setoran atau penarikan.
     */
    public function updateSaldo($nasabah_id, $jumlah, $tipe_transaksi)
    {
        $saldo = Saldo::where('nasabah_id', $nasabah_id)->first();

        if ($saldo) {
            if ($tipe_transaksi == 'setoran') {
                $saldo->saldo_akhir += $jumlah;
            } elseif ($tipe_transaksi == 'penarikan') {
                if ($saldo->saldo_akhir >= $jumlah) {
                    $saldo->saldo_akhir -= $jumlah;
                } else {
                    return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk melakukan penarikan.');
                }
            }

            $saldo->save();
        }

        return redirect()->route('saldo.index')->with('success', 'Saldo nasabah berhasil diperbarui.');
    }
}
