<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_kelamin',
                'alamat',
                'foto'
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['L','P'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();
        });
    }
};
