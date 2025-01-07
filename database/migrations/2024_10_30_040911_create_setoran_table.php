<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetoranTable extends Migration
{
    public function up(): void
    {
        Schema::create('setorans', function (Blueprint $table) {
            $table->id();
            $table->string('id_setoran')->unique();
            $table->foreignId('nasabah_id')->constrained('nasabahs')->onDelete('cascade');
            $table->string('nama_nasabah');
            $table->string('id_nasabah');
            $table->string('kelas');
            $table->date('tanggal_transaksi');
            $table->decimal('jumlah_setoran', 15, 2);
            $table->timestamps();
        });        
    }

    public function down(): void
    {
        Schema::dropIfExists('setorans');
    }
}