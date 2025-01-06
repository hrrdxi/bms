<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\Nasabah;
use Illuminate\Http\Request;

class SaldoController extends Controller
{
    /**
     * Menampilkan halaman saldo dan daftar saldo nasabah.
     */
    public function index()
    {
        // Ambil semua data nasabah dan saldonya
        $nasabahs = Nasabah::all();
        $saldos = Saldo::with('nasabah')->paginate(10); // Paginasi saldo nasabah

        return view('saldo', compact('nasabahs', 'saldos'));
    }

    /**
     * Cek saldo nasabah atau menambahkan saldo awal otomatis.
     */
    public function cekSaldoNasabah(Request $request)
    {
        // Validasi input
        $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id', // Validasi nasabah_id
        ]);
    
        // Cari nasabah
        $nasabah = Nasabah::findOrFail($request->nasabah_id);
    
        // Cek apakah nasabah sudah memiliki saldo
        $saldo = Saldo::where('nasabah_id', $nasabah->id)->first();
    
        if (!$saldo) {
            // Jika nasabah belum memiliki saldo, buat saldo baru
            $saldo = Saldo::create([
                'nasabah_id' => $nasabah->id, // Pastikan nasabah_id disimpan
                'saldo_awal' => 10000, // Saldo awal default 10.000
                'saldo_akhir' => 10000, // Saldo akhir default 10.000
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
        // Temukan saldo nasabah
        $saldo = Saldo::where('nasabah_id', $nasabah_id)->first();

        if ($saldo) {
            if ($tipe_transaksi == 'setoran') {
                // Tambahkan jumlah ke saldo akhir
                $saldo->saldo_akhir += $jumlah;
            } elseif ($tipe_transaksi == 'penarikan') {
                // Kurangi jumlah dari saldo akhir
                if ($saldo->saldo_akhir >= $jumlah) {
                    $saldo->saldo_akhir -= $jumlah;
                } else {
                    return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk melakukan penarikan.');
                }
            }

            // Simpan perubahan saldo
            $saldo->save();
        }

        return redirect()->route('saldo.index')->with('success', 'Saldo nasabah berhasil diperbarui.');
    }
}