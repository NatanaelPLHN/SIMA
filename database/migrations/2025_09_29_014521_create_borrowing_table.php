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
            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('borrowed_by');
            $table->integer('jumlah');
            $table->dateTime('tanggal_pinjam');
            $table->dateTime('tanggal_kembali')->nullable();
            $table->string('status');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('asset_id')->references('id')->on('aset')->onDelete('cascade');
            $table->foreign('borrowed_by')->references('id')->on('employees')->onDelete('cascade');

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
