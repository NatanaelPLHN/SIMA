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
    Schema::create('assets_bergerak', function (Blueprint $table) {
        $table->id('asset_id'); 
        $table->foreign('asset_id')->references('id')->on('assets')->cascadeOnDelete();
        $table->string('merk')->nullable();
        $table->string('tipe')->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets_bergerak');
    }
};
