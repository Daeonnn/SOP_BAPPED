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
        Schema::create('aktivitas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('kelengkapan');
            $table->string('waktu');
            $table->string('output');
            $table->string('keterangan');
            $table->unsignedBigInteger('pelaksana_id');
            $table->timestamps();

            $table->foreign('pelaksana_id')->references('id')->on('pelaksana')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivitas');
    }
};
