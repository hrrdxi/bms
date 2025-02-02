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
        Schema::table('penarikans', function (Blueprint $table) {
            // Tambahkan kolom user_id jika belum ada
            if (!Schema::hasColumn('penarikans', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id'); // Letakkan setelah kolom 'id'
            }
        });
    }

    public function down()
    {
        Schema::table('penarikans', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
