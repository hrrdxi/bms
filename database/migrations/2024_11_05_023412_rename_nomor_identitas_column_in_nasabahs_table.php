<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameNomorIdentitasColumnInNasabahsTable extends Migration
{
    public function up()
    {
        Schema::table('nasabahs', function (Blueprint $table) {
            $table->renameColumn('nomor_identitas', 'no_identitas');
        });
    }

    public function down()
    {
        Schema::table('nasabahs', function (Blueprint $table) {
            $table->renameColumn('no_identitas', 'nomor_identitas');
        });
    }
}
