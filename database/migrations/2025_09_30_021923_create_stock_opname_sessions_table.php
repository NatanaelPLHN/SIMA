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
        Schema::create('stock_opname_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            // $table->foreign('scheduled_by')->references('id')->on('users')->onDelete('cascade'); //foreign key id user yang menjadwalkan
            $table->foreignId('scheduled_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('departement_id')->constrained('departements')->cascadeOnDelete();
            $table->dateTime('tanggal_dijadwalkan');
            $table->dateTime('tanggal_dimulai')->nullable();
            $table->dateTime('tanggal_selesai')->nullable();
            $table->enum('status', ['draft','cancelled','dijadwalkan','selesai'])->default('draft');
            $table->text('catatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_opname_sessions');
    }
};
