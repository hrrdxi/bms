<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('nasabahs', function (Blueprint $table) {
        if (!Schema::hasColumn('nasabahs', 'angka_kelas')) {
            $table->integer('angka_kelas')->nullable();
        }
    });
}

public function down()
{
    Schema::table('nasabahs', function (Blueprint $table) {
        $table->dropColumn('angka_kelas');
    });
}

};
