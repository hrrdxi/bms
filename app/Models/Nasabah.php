<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;
    protected $table = 'nasabahs'; 

    protected $fillable = [
        'id_nasabah',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'no_telepon',
        'kelas',
        'jurusan',
        'no_identitas',
        'foto_kartu_pelajar',
        'angka_kelas',
        'jenis_tabungan',
        'saldo'
    ];
    
    /**
     * Relasi dengan model Saldo
     */
    public function saldo()
    {
        return $this->hasOne(Saldo::class, 'nasabah_id', 'id');
    }    
    // Relasi ke model Setoran
    public function setorans()
    {
        return $this->hasMany(Setoran::class);
    }

    // Relasi ke model Penarikan
    public function penarikan()
    {
        return $this->hasMany(Penarikan::class);
    }

    // Pastikan saldo awal nasabah selalu 0 saat nasabah baru dibuat
    protected static function booted()
    {
        static::creating(function ($nasabah) {
            $nasabah->saldo = 0;
        });
    }
}