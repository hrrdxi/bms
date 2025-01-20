<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Setoran;
use App\Models\Penarikan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Set timezone untuk Indonesia
        config(['app.timezone' => 'Asia/Jakarta']);
        
        // Hitung statistik hari ini
        $startOfDay = Carbon::today();
        $endOfDay = Carbon::today()->endOfDay();

        $setoranHariIni = Setoran::whereBetween('tanggal_transaksi', [$startOfDay, $endOfDay]);
        $penarikanHariIni = Penarikan::whereBetween('tanggal_penarikan', [$startOfDay, $endOfDay]);

        $totalSetoranHariIni = $setoranHariIni->sum('jumlah_setoran');
        $totalPenarikanHariIni = $penarikanHariIni->sum('jumlah_penarikan');
        $jumlahTransaksiHariIni = $setoranHariIni->count() + $penarikanHariIni->count();

        // Hitung statistik bulan ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $setoranBulanIni = Setoran::whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth]);
        $penarikanBulanIni = Penarikan::whereBetween('tanggal_penarikan', [$startOfMonth, $endOfMonth]);

        $totalSetoranBulanan = $setoranBulanIni->sum('jumlah_setoran');
        $totalPenarikanBulanan = $penarikanBulanIni->sum('jumlah_penarikan');
        $jumlahTransaksiBulanan = $setoranBulanIni->count() + $penarikanBulanIni->count();

        // Hitung total keseluruhan (semua waktu)
        $totalSetoranAll = Setoran::sum('jumlah_setoran');
        $totalPenarikanAll = Penarikan::sum('jumlah_penarikan');
        
        // Hitung saldo akhir keseluruhan
        $saldoAkhir = $totalSetoranAll - $totalPenarikanAll;

        // Ambil statistik transaksi per bulan (untuk grafik)
        $transaksiPerBulan = DB::table(function($query) {
            $query->select(
                DB::raw('MONTH(tanggal_transaksi) as bulan'),
                DB::raw('YEAR(tanggal_transaksi) as tahun'),
                DB::raw('SUM(jumlah_setoran) as total_setoran'),
                DB::raw("'setoran' as tipe")
            )
            ->from('setorans')
            ->groupBy('bulan', 'tahun')
            ->union(
                DB::table('penarikans')
                    ->select(
                        DB::raw('MONTH(tanggal_penarikan) as bulan'),
                        DB::raw('YEAR(tanggal_penarikan) as tahun'),
                        DB::raw('SUM(jumlah_penarikan) as total'),
                        DB::raw("'penarikan' as tipe")
                    )
                    ->groupBy('bulan', 'tahun')
            );
        }, 'combined_data')
        ->select(
            'bulan',
            'tahun',
            'tipe',
            'total_setoran as total'
        )
        ->orderBy('tahun', 'desc')
        ->orderBy('bulan', 'desc')
        ->limit(12)
        ->get();

        // Hitung statistik pengguna
        $totalPengguna = User::count();
        $penggunaTerakhir = User::latest()->first();

        // Transaksi terbaru (gabungan setoran dan penarikan)
        $transaksiTerbaru = collect();
        
        $setoran = Setoran::with('user')
            ->orderBy('tanggal_transaksi', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'setoran',
                    'tanggal' => $item->tanggal_transaksi,
                    'jumlah' => $item->jumlah_setoran,
                    'user' => $item->user?->nama, // Tambahkan null safe operator
                    'keterangan' => $item->keterangan
                ];
            });
            
        $penarikan = Penarikan::with('user')
            ->orderBy('tanggal_penarikan', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'penarikan',
                    'tanggal' => $item->tanggal_penarikan,
                    'jumlah' => $item->jumlah_penarikan,
                    'user' => $item->user?->nama, // Tambahkan null safe operator
                    'keterangan' => $item->keterangan
                ];
            });

        $transaksiTerbaru = $setoran->concat($penarikan)
            ->sortByDesc('tanggal')
            ->take(5);

        // Persentase perubahan dari bulan lalu
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
        
        $totalSetoranBulanLalu = Setoran::whereBetween('tanggal_transaksi', 
            [$startOfLastMonth, $endOfLastMonth])->sum('jumlah_setoran');
        $totalPenarikanBulanLalu = Penarikan::whereBetween('tanggal_penarikan', 
            [$startOfLastMonth, $endOfLastMonth])->sum('jumlah_penarikan');

        $perubahanSetoran = $totalSetoranBulanLalu != 0 ? 
            (($totalSetoranBulanan - $totalSetoranBulanLalu) / $totalSetoranBulanLalu) * 100 : 100;
        $perubahanPenarikan = $totalPenarikanBulanLalu != 0 ? 
            (($totalPenarikanBulanan - $totalPenarikanBulanLalu) / $totalPenarikanBulanLalu) * 100 : 100;

        return view('dashboard', compact(
            'totalSetoranHariIni',
            'totalPenarikanHariIni',
            'jumlahTransaksiHariIni',
            'totalSetoranBulanan',
            'totalPenarikanBulanan',
            'jumlahTransaksiBulanan',
            'saldoAkhir',
            'transaksiPerBulan',
            'totalPengguna',
            'penggunaTerakhir',
            'transaksiTerbaru',
            'perubahanSetoran',
            'perubahanPenarikan'
        ));
    }
}