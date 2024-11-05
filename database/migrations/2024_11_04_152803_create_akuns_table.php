<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('akun', function (Blueprint $table) {
            $table->id();
            $table->string('no_akun');
            $table->string('nama_akun');
            $table->enum('tipe_akun', ['d', 'k']);
            $table->timestamps();
        });

        DB::table('akun')->insert([
            'no_akun' => '111',
            'nama_akun' => 'Kas',
            'tipe_akun' => 'd',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('akun')->insert([
            'no_akun' => '411',
            'nama_akun' => 'Pendanaan',
            'tipe_akun' => 'k',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('akun')->insert([
            'no_akun' => '511',
            'nama_akun' => 'Biaya Operasional',
            'tipe_akun' => 'd',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun');
    }
};
