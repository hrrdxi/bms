<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SetoranController;
use App\Http\Controllers\PenarikanController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PenarikanHariIniController;
use App\Http\Controllers\SemuaPenarikanController;
use App\Http\Controllers\SetoranHariIniController;
use App\Http\Controllers\SemuaSetoranController;
use App\Http\Controllers\DataLainController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::get('/home', [HomeController::class, 'index'
])->middleware('auth')->name('home');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


Route::resource('setoran', SetoranController::class);
Route::resource('penarikan', PenarikanController::class);
Route::resource('nasabah', NasabahController::class);

Route::get('/saldo', [SaldoController::class, 'index'])->name('saldo.index');
Route::post('/saldo/cek', [SaldoController::class, 'cekSaldo'])->name('saldo.cek');
Route::get('/api/nasabah/{id}/saldo', [SaldoController::class, 'cekSaldo']);

Route::get('/penarikan-hari-ini', [PenarikanHariIniController::class, 'index'])->name('penarikan.cekHariIni');
Route::get('/semua-penarikan', [SemuaPenarikanController::class, 'index'])->name('penarikan.cekSemua');
Route::get('/penarikan/{id}/download-slip', [PenarikanController::class, 'downloadSlip'])
    ->name('penarikan.download-slip');
Route::get('/penarikan/{id}/print-slip', [PenarikanController::class, 'printSlip'])
    ->name('penarikan.print-slip');
    
Route::get('/setoran-hari-ini', [SetoranHariIniController::class, 'index'])->name('setoran.cekHariIni');
Route::get('/semua-setoran', [SemuaSetoranController::class, 'index'])->name('setoran.cekSemua');
Route::get('/setoran/{id}/download-slip', [SetoranController::class, 'downloadSlip'])
    ->name('setoran.download-slip');
Route::get('/setoran/{id}/print-slip', [SetoranController::class, 'printSlip'])
    ->name('setoran.print-slip');
    
Route::get('/nasabah/{nasabah}/download-card', [NasabahController::class, 'downloadCard'])
    ->name('nasabah.download-card');
Route::get('/nasabah/verify/{id}', [NasabahController::class, 'verify'])->name('nasabah.verify');
Route::get('/nasabah/detail-qr/{id}', [NasabahController::class, 'showQRDetail'])
    ->name('nasabah.detail-qr');

    Route::get('/data-lain', [DataLainController::class, 'index'])->name('data-lain.index');
    Route::get('/data-lain/datamingguan', [DataLainController::class, 'dataMingguan'])->name('data-lain.mingguan');
    Route::get('/data-lain/bulanan', [DataLainController::class, 'dataBulanan'])->name('data-lain.bulanan');
    Route::get('/data-lain/master', [DataLainController::class, 'dataMaster'])->name('data-lain.master');
    Route::get('/penarikan-hari-ini', [PenarikanHariIniController::class, 'index'])->name('penarikan.cekHariIni');
    Route::get('/semua-penarikan', [SemuaPenarikanController::class, 'index'])->name('penarikan.cekSemua');
    

require __DIR__.'/auth.php';
