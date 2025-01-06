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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', [HomeController::class, 'index'
])->middleware('auth')->name('home');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


Route::resource('setoran', SetoranController::class);
Route::resource('penarikan', PenarikanController::class);
Route::resource('nasabah', NasabahController::class);

// Route untuk halaman saldo
Route::get('/saldo', [SaldoController::class, 'index'])->name('saldo.index');

// Route untuk setoran atau penarikan
Route::post('/saldo/cek', [SaldoController::class, 'cekSaldoNasabah'])->name('saldo.cek');


Route::get('user/transaksi', [TransaksiController::class, 'index'])->name('transaksis.index');
Route::post('user/transaksi', [TransaksiController::class, 'store'])->name('transaksis.store');



require __DIR__.'/auth.php';
