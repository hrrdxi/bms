<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('nasabahs', function (Blueprint $table) {
            $table->string('jurusan')->nullable()->change();
            $table->string('angka_kelas')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('nasabahs', function (Blueprint $table) {
            $table->string('jurusan')->nullable(false)->change();
            $table->string('angka_kelas')->nullable(false)->change();
        });
    }
};