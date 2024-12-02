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
            $table->text('dasar_hukum');
            $table->text('keterkaitan');
            $table->text('peringatan');
            $table->string('no_sop');
            $table->date('tgl_pembuatan');
            $table->date('tgl_revisi');
            $table->date('tgl_aktif');
            $table->text('kualifikasi_pelaksana');
            $table->text('perlengkapan');
            $table->text('pencatatan');
            $table->unsignedBigInteger('sub_bidang_id');
            $table->timestamps();

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
