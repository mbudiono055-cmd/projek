<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->enum('status', [
                'menunggu',
                'diterima',
                'ditolak',
                'dikembalikan',
                'terlambat'
            ])->default('menunggu')->change();
        });
    }

    public function down()
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->enum('status', [
                'menunggu',
                'diterima',
                'ditolak',
                'dikembalikan'
            ])->default('menunggu')->change();
        });
    }
};
