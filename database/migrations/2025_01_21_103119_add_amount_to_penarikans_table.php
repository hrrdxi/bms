<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountToPenarikansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('penarikans', function (Blueprint $table) {
            $table->decimal('amount', 15, 2)->after('tanggal_penarikan'); // Tambahkan kolom amount
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penarikans', function (Blueprint $table) {
            $table->dropColumn('amount'); // Hapus kolom amount jika rollback
        });
    }
}
