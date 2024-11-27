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
        Schema::create('sops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nomor_sk')->unique(); // Kolom Nomor SK
            $table->year('tahun'); // Kolom Tahun
            $table->enum('hasil_monitoring', ['penghapusan', 'revisi', 'penggabungan', 'penambahan'])->nullable();// Kolom Penghapusan
            $table->year('tahun_perubahan')->nullable(); // Kolom Tahun Perubahan
            $table->text('keterangan')->nullable(); // Kolom Keterangan
            $table->string('file_sk')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sops');
    }
};
