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
        Schema::create('pelaksana', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('cover_sop_id');
            $table->timestamps();

            $table->foreign('cover_sop_id')->references('id')->on('cover_sop')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaksana');
    }
};
