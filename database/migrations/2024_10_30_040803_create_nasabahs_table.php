<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNasabahsTable extends Migration
{
    /**
     * Jalankan migrasi.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nasabahs', function (Blueprint $table) {
            $table->id();
            $table->string('id_nasabah')->unique(); // ID unik untuk setiap nasabah
            $table->string('nama');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('no_telepon');
            $table->string('kelas');
            $table->string('jurusan');
            $table->string('no_identitas')->unique(); // Ubah dari 'nomor_identitas' ke 'no_identitas'
            $table->string('foto_kartu_pelajar')->nullable(); // Foto kartu pelajar, opsional
            $table->unsignedTinyInteger('angka_kelas')->nullable(); // Kolom angka_kelas yang dapat bernilai null
            $table->decimal('saldo', 15, 2)->default(0); // Saldo dengan nilai default 0
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Balikkan migrasi.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nasabahs'); // Pastikan nama tabel adalah 'nasabahs'
    }
}
