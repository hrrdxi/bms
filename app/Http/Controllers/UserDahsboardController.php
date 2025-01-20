<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Setoran;
use App\Models\Penarikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDahsboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Hitung transaksi hari ini
        $startOfDay = Carbon::today();
        $endOfDay = Carbon::today()->endOfDay();
        
        $setoranHariIni = Setoran::where('user_id', $user->id)
            ->whereBetween('tanggal_transaksi', [$startOfDay, $endOfDay])
            ->get();
            
        $penarikanHariIni = Penarikan::where('user_id', $user->id)
            ->whereBetween('tanggal_penarikan', [$startOfDay, $endOfDay])
            ->get();
            
        $totalSetoranHariIni = $setoranHariIni->sum('jumlah_setoran');
        $totalPenarikanHariIni = $penarikanHariIni->sum('jumlah_penarikan');

        // Hitung transaksi bulan ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $setoranBulanIni = Setoran::where('user_id', $user->id)
            ->whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
            ->get();
            
        $penarikanBulanIni = Penarikan::where('user_id', $user->id)
            ->whereBetween('tanggal_penarikan', [$startOfMonth, $endOfMonth])
            ->get();
            
        $totalSetoranBulanan = $setoranBulanIni->sum('jumlah_setoran');
        $totalPenarikanBulanan = $penarikanBulanIni->sum('jumlah_penarikan');

        // Hitung total saldo keseluruhan
        $totalSetoran = Setoran::where('user_id', $user->id)->sum('jumlah_setoran');
        $totalPenarikan = Penarikan::where('user_id', $user->id)->sum('jumlah_penarikan');
        $saldoAkhir = $totalSetoran - $totalPenarikan;

        // Ambil riwayat transaksi terbaru
        $recentTransactions = collect();
        
        // Gabung setoran
        $setoran = Setoran::where('user_id', $user->id)
            ->orderBy('tanggal_transaksi', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'setoran',
                    'tanggal_transaksi' => $item->tanggal_transaksi,
                    'jumlah' => $item->jumlah_setoran,
                    'keterangan' => $item->keterangan
                ];
            });
            
        // Gabung penarikan    
        $penarikan = Penarikan::where('user_id', $user->id)
            ->orderBy('tanggal_penarikan', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'penarikan', 
                    'tanggal_transaksi' => $item->tanggal_penarikan,
                    'jumlah' => $item->jumlah_penarikan,
                    'keterangan' => $item->keterangan
                ];
            });

        // Gabungkan dan urutkan transaksi
        $recentTransactions = $setoran->concat($penarikan)
            ->sortByDesc('tanggal_transaksi')
            ->take(5);

        return view('user.dashboard', compact(
            'user',
            'totalSetoranHariIni',
            'totalPenarikanHariIni', 
            'setoranBulanIni',
            'penarikanBulanIni',
            'totalSetoranBulanan',
            'totalPenarikanBulanan',
            'saldoAkhir',
            'recentTransactions'
        ));
    }

    public function storeSetoran(Request $request)
    {
        $request->validate([
            'jumlah_setoran' => 'required|numeric|min:1000',
            'keterangan' => 'nullable|string|max:255'
        ]);

        $setoran = new Setoran();
        $setoran->user_id = Auth::id();
        $setoran->jumlah_setoran = $request->jumlah_setoran;
        $setoran->keterangan = $request->keterangan;
        $setoran->tanggal_transaksi = now();
        $setoran->save();

        return redirect()->back()->with('success', 'Setoran berhasil disimpan!');
    }

    public function storePenarikan(Request $request)
    {
        $request->validate([
            'jumlah_penarikan' => 'required|numeric|min:1000',
            'keterangan' => 'nullable|string|max:255'
        ]);

        // Cek saldo mencukupi
        $totalSetoran = Setoran::where('user_id', Auth::id())->sum('jumlah_setoran');
        $totalPenarikan = Penarikan::where('user_id', Auth::id())->sum('jumlah_penarikan');
        $saldoTersedia = $totalSetoran - $totalPenarikan;

        if ($request->jumlah_penarikan > $saldoTersedia) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk melakukan penarikan!');
        }

        $penarikan = new Penarikan();
        $penarikan->user_id = Auth::id();
        $penarikan->jumlah_penarikan = $request->jumlah_penarikan;
        $penarikan->keterangan = $request->keterangan;
        $penarikan->tanggal_penarikan = now();
        $penarikan->save();

        return redirect()->back()->with('success', 'Penarikan berhasil dilakukan!');
    }
}