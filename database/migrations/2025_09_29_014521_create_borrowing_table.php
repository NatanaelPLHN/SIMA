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
        Schema::create('borrowing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id')->nullable();
            $table->unsignedBigInteger('borrowed_by')->nullable();
            $table->integer('jumlah');
            $table->dateTime('tanggal_pinjam');
            $table->dateTime('tanggal_kembali')->nullable();
            $table->enum('status', ['dipakai','dikembalikan'])->default('dipakai');
            $table->string('tujuan_penggunaan');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('asset_id')->references('id')->on('aset')->onDelete('set null');
            $table->foreign('borrowed_by')->references('id')->on('employees')->onDelete('set null');

            // Indexes for better performance
            $table->index(['asset_id']);
            $table->index(['borrowed_by']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowing');
    }
};
