<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Nasabah;

class Penarikan extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'id_penarikan',
        'nasabah_id',
        'nama_nasabah',
        'kelas',
        'keterangan_penarikan',
        'tanggal_penarikan',
        'jumlah_penarikan',
        'amount',
        'user_id',
    ];
    

    /**
     * Relasi: Penarikan dimiliki oleh satu nasabah.
     */
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    /**
     * Mengurangi saldo nasabah setelah penarikan dibuat.
     */
    protected static function booted()
    {
        static::created(function ($penarikan) {
            $nasabah = Nasabah::findOrFail($penarikan->nasabah_id);

            if ($nasabah->saldo >= $penarikan->jumlah_penarikan) {
                $nasabah->saldo -= $penarikan->jumlah_penarikan; // Kurangi saldo
                $nasabah->save();
            } else {
                throw new \Exception('Saldo tidak cukup untuk melakukan penarikan.');
            }
        });
    }
}
