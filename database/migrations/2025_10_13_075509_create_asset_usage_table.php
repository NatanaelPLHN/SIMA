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
        Schema::create('asset_usage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id')->nullable(); // Pastikan tipe data sama
            $table->unsignedBigInteger('used_by')->nullable(); // Pastikan tipe data sama
            $table->unsignedBigInteger('department_id')->nullable(); // Pastikan tipe data sama
            $table->date('start_date');
            $table->string('tujuan_penggunaan')->nullable();
            $table->enum('status', ['dipakai', 'dikembalikan'])->default('dipakai');
            $table->text('keterangan')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('asset_id')->references('id')->on('aset')->onDelete('set null');
            $table->foreign('used_by')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('departements')->onDelete('set null');

            // Indexes
            $table->index(['asset_id']);
            $table->index(['used_by']);
            $table->index(['department_id']);
            $table->index(['status']);
            $table->index(['start_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_usage');
    }
};