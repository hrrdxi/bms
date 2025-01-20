<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nasabah_id',
        'saldo_awal',
        'saldo_akhir',
    ];

    /**
     * Relasi dengan model Nasabah
     */
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'nasabah_id', 'id');
    }
    
}
