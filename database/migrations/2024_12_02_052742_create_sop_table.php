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
        Schema::create('sop', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aktivitas_id');
            $table->unsignedBigInteger('cover_sop_id');
            $table->timestamps();

            $table->foreign('cover_sop_id')->references('id')->on('cover_sop')->onDelete('cascade');
            $table->foreign('aktivitas_id')->references('id')->on('aktivitas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sop');
    }
};
