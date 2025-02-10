<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJenisTabunganToNasabahsTable extends Migration
{
    public function up()
    {
        Schema::table('nasabahs', function (Blueprint $table) {
            $table->enum('jenis_tabungan', ['Wadiah', 'Mudharabah', 'Deposito Mudharabah'])
                  ->after('angka_kelas');
        });
    }

    public function down()
    {
        Schema::table('nasabahs', function (Blueprint $table) {
            $table->dropColumn('jenis_tabungan');
        });
    }
}