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
        Schema::create('bidang', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kepala_bidang')->nullable();
            $table->string('lokasi')->nullable();
            $table->unsignedBigInteger('instansi_id');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('instansi_id')->references('id')->on('institutions')->onDelete('cascade');

            // Indexes
            $table->index(['instansi_id']);
            $table->index(['kepala_bidang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidang');
    }
};
