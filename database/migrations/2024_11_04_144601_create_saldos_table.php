<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaldosTable extends Migration
{
    public function up()
    {
        Schema::create('saldos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nasabah_id')->constrained()->onDelete('cascade'); // Foreign key ke tabel nasabahs
            $table->decimal('saldo_awal', 15, 2)->default(10000); // Default saldo awal 10.000
            $table->decimal('saldo_akhir', 15, 2)->default(10000); // Default saldo akhir 10.000
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('saldos');
    }
}