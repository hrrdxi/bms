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
            // Pastikan kolom user_id ada sebelum diubah
            if (Schema::hasColumn('penarikans', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->change();
            }
        });
    }

    public function down()
    {
        Schema::table('penarikans', function (Blueprint $table) {
            if (Schema::hasColumn('penarikans', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable(false)->change();
            }
        });
    }
};
