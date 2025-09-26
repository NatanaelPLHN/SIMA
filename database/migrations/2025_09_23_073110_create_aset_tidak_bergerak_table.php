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
    Schema::create('aset_tidak_bergerak', function (Blueprint $table) {
        $table->id('aset_id');
        $table->foreign('aset_id')->references('id')->on('aset')->cascadeOnDelete();

        $table->string('ukuran')->nullable(); // contoh: 100m2
        $table->string('bahan')->nullable();  // contoh: beton, kayu, baja
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset_tidak_bergerak');
    }
};
