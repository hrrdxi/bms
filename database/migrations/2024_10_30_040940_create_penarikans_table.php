<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenarikansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penarikans', function (Blueprint $table) {
            $table->id();
            $table->string('id_penarikan')->unique();
            $table->foreignId('nasabah_id')->constrained('nasabahs')->onDelete('cascade'); // Relasi ke Nasabah
            $table->string('nama_nasabah');
            $table->string('kelas');
            $table->text('keterangan_penarikan');
            $table->date('tanggal_penarikan');
            $table->decimal('jumlah_penarikan', 15, 2);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penarikans');
    }
}
