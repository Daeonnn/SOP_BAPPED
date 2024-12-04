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
        Schema::create('cover_sop', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('dasar_hukum')->nullable();
            $table->text('keterkaitan')->nullable();
            $table->text('peringatan')->nullable();
            $table->string('no_sop')->nullable();
            $table->string('tgl_pembuatan')->nullable();
            $table->string('tgl_revisi')->nullable();
            $table->string('tgl_aktif')->nullable();
            $table->text('kualifikasi_pelaksana')->nullable();
            $table->text('perlengkapan')->nullable();
            $table->text('pencatatan')->nullable();
            $table->unsignedBigInteger('bidang_id')->nullable();
            $table->unsignedBigInteger('sub_bidang_id')->nullable();
            $table->enum('status', ['Diterima', 'Revisi', 'Perlu Dilengkapi','Menunggu'])->default('Perlu Dilengkapi');
            $table->timestamps();

            $table->foreign('bidang_id')->references('id')->on('bidang')->onDelete('cascade');
            $table->foreign('sub_bidang_id')->references('id')->on('sub_bidang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cover_sop');
    }
};
