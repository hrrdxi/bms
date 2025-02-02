<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SemuaNasabahController;
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


//CRUD PENARIKAN
Route::get('/penarikan.index', [PenarikanController::class, 'index'])->name('penarikan.index');
Route::get('/penarikan/create', [PenarikanController::class, 'create'])->name('penarikan.create');
Route::post('/penarikan', [PenarikanController::class, 'store'])->name('penarikan.store');
Route::get('/penarikan/{penarikan}/edit', [PenarikanController::class, 'edit'])->name('penarikan.edit');
Route::put('/penarikan/{penarikan}', [PenarikanController::class, 'update'])->name('penarikan.update');
Route::delete('/penarikan/{penarikan}', [PenarikanController::class, 'destroy'])->name('penarikan.destroy');
//FUNGSI PENARIKAN
Route::get('/penarikan-hari-ini', [PenarikanHariIniController::class, 'index'])->name('penarikan.cekHariIni');
Route::get('/semua-penarikan', [SemuaPenarikanController::class, 'index'])->name('penarikan.cekSemua');
Route::get('/penarikan/{id}/download-slip', [PenarikanController::class, 'downloadSlip'])
    ->name('penarikan.download-slip');
Route::get('penarikan/{id}/print-slip', [PenarikanController::class, 'printSlip'])->name('penarikan.print-slip');
Route::get('/penarikan', [PenarikanController::class, 'search'])->name('penarikan.search');


//CRUD SETORAN
Route::get('/setoran.index', [SetoranController::class, 'index'])->name('setoran.index');
Route::get('/setoran/create', [SetoranController::class, 'create'])->name('setoran.create');
Route::post('/setoran', [SetoranController::class, 'store'])->name('setoran.store');
Route::get('/setoran/{setoran}/edit', [SetoranController::class, 'edit'])->name('setoran.edit');
Route::put('/setoran/{setoran}', [SetoranController::class, 'update'])->name('setoran.update');
Route::delete('/setoran/{setoran}', [SetoranController::class, 'destroy'])->name('setoran.destroy');
//FUNGSI SETORAN
Route::get('/setoran-hari-ini', [SetoranHariIniController::class, 'index'])->name('setoran.cekHariIni');
Route::get('/semua-setoran', [SemuaSetoranController::class, 'index'])->name('setoran.cekSemua');
Route::get('/setoran/{id}/download-slip', [SetoranController::class, 'downloadSlip'])
    ->name('setoran.download-slip');
Route::get('setoran/{id}/print-slip', [SetoranController::class, 'printSlip'])->name('setoran.print-slip');
Route::get('/setoran', [SetoranController::class, 'search'])->name('setoran.search');


//CRUD NASABAH
Route::get('/nasabah.index', [NasabahController::class, 'index'])->name('nasabah.index');
Route::get('/nasabah/create', [NasabahController::class, 'create'])->name('nasabah.create');
Route::post('/nasabah', [NasabahController::class, 'store'])->name('nasabah.store');
Route::get('/nasabah/{nasabah}/edit', [NasabahController::class, 'edit'])->name('nasabah.edit');
Route::put('/nasabah/{nasabah}', [NasabahController::class, 'update'])->name('nasabah.update');
Route::delete('/nasabah/{nasabah}', [NasabahController::class, 'destroy'])->name('nasabah.destroy');
//FUNGSI NASABAH
Route::get('/nasabah/{nasabah}/download-card', [NasabahController::class, 'downloadCard'])
    ->name('nasabah.download-card');
Route::get('/nasabah/verify/{id}', [NasabahController::class, 'verify'])->name('nasabah.verify');
Route::get('/nasabah/detail-qr/{id}', [NasabahController::class, 'showQRDetail'])
    ->name('nasabah.detail-qr');
Route::get('/semua-nasabah', [SemuaNasabahController::class, 'index'])->name('nasabah.cekSemua');
Route::get('/nasabah/{id}', [NasabahController::class, 'show'])->name('nasabah.show');
Route::get('/nasabah', [NasabahController::class, 'search'])->name('nasabah.search');


//DATA LAIN
Route::get('/data-lain', [DataLainController::class, 'index'])->name('data-lain.index');
Route::get('/data-lain/datamingguan', [DataLainController::class, 'dataMingguan'])->name('data-lain.mingguan');
Route::get('/data-lain/bulanan', [DataLainController::class, 'dataBulanan'])->name('data-lain.bulanan');
Route::get('/data-lain/master', [DataLainController::class, 'dataMaster'])->name('data-lain.master');
Route::get('/penarikan-hari-ini', [PenarikanHariIniController::class, 'index'])->name('penarikan.cekHariIni');
Route::get('/semua-penarikan', [SemuaPenarikanController::class, 'index'])->name('penarikan.cekSemua');
    

//CEK SALDO
Route::get('/saldo', [SaldoController::class, 'index'])->name('saldo.index');
Route::post('/saldo/cek', [SaldoController::class, 'cekSaldo'])->name('saldo.cek');
Route::get('/api/nasabah/{id}/saldo', [SaldoController::class, 'cekSaldo']);

require __DIR__.'/auth.php';
