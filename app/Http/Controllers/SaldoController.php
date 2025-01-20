<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\Nasabah;
use App\Models\Setoran;
use App\Models\Penarikan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SaldoController extends Controller
{
    /**
     * Menampilkan halaman pengelolaan saldo.
     */
    public function index()
    {
        $nasabahs = Nasabah::all();
        $saldos = Saldo::with('nasabah')->paginate(10);
        return view('saldo', compact('nasabahs', 'saldos'));
    }

    /**
     * Mengecek saldo nasabah.
     */
    public function cekSaldo(Request $request)
    {
        $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id',
        ]);

        $nasabah = Nasabah::with('saldo')->find($request->nasabah_id);

        if (!$nasabah->saldo) {
            $saldo = Saldo::create([
                'nasabah_id' => $nasabah->id,
                'saldo_awal' => 10000,
                'saldo_akhir' => 10000,
            ]);

            return redirect()->route('saldo.index')
                ->with('success', "Saldo awal sebesar Rp 10.000 telah ditambahkan untuk {$nasabah->nama}");
        }

        return response()->json([
            'status' => 'success',
            'data' => $nasabah->saldo,
        ]);
    }

    /**
     * Menampilkan halaman data tambahan.
     */
    public function dataLain()
    {
        $weeklyData = $this->getWeeklyData();
        $monthlyData = $this->getMonthlyData();

        $topNasabahs = Nasabah::with('saldo')
            ->whereHas('saldo')
            ->orderByDesc('saldo.saldo_akhir')
            ->take(5)
            ->get();

        return view('saldo.datalain', compact('weeklyData', 'monthlyData', 'topNasabahs'));
    }

    /**
     * Mendapatkan data mingguan.
     */
    private function getWeeklyData()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $weeklyDeposit = Setoran::whereBetween('tanggal', [$startOfWeek, $endOfWeek])->sum('jumlah');
        $weeklyWithdrawal = Penarikan::whereBetween('tanggal', [$startOfWeek, $endOfWeek])->sum('jumlah');
        $dailyTransactions = [];

        for ($date = $startOfWeek; $date <= $endOfWeek; $date->addDay()) {
            $dailyTransactions[] = [
                'date' => $date->format('Y-m-d'),
                'deposits' => Setoran::whereDate('tanggal', $date)->sum('jumlah'),
                'withdrawals' => Penarikan::whereDate('tanggal', $date)->sum('jumlah'),
            ];
        }

        return [
            'weeklyDeposit' => $weeklyDeposit,
            'weeklyWithdrawal' => $weeklyWithdrawal,
            'dailyTransactions' => $dailyTransactions,
        ];
    }

    /**
     * Mendapatkan data bulanan.
     */
    private function getMonthlyData()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return DB::table('setorans')
            ->select(DB::raw('DATE(tanggal) as date'), DB::raw('SUM(jumlah) as total_setoran'))
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->groupBy('date')
            ->get();
    }
}
