<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Nasabah;

class Setoran extends Model
{
    use HasFactory;

    // Kolom-kolom yang bisa diisi secara mass-assignment
    protected $fillable = [
        'id_setoran', 'nasabah_id', 'nama_nasabah', 'id_nasabah',
        'kelas', 'tanggal_transaksi', 'jumlah_setoran'
    ];

    /**
     * Relasi: Setoran dimiliki oleh satu nasabah.
     */
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    /**
     * Tambahkan jumlah setoran ke saldo nasabah saat setoran dibuat.
     */
    protected static function booted()
    {
        static::created(function ($setoran) {
            $nasabah = Nasabah::findOrFail($setoran->nasabah_id);
            $nasabah->saldo += $setoran->jumlah_setoran; // Tambahkan setoran ke saldo
            $nasabah->save(); // Simpan perubahan saldo
        });
    }
}
