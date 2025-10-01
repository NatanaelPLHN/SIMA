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
        Schema::create('stock_opname_details', function (Blueprint $table) {
            $table->id();
            // $table->foreign('stock_opname_id')->references('id')->on('stock_opname_sessions')->onDelete('cascade');
            $table->foreignId('stock_opname_id')->constrained('stock_opname_sessions')->cascadeOnDelete();
            // $table->foreign('aset_id')->references('id')->on('aset')->onDelete('cascade');
            $table->foreignId('aset_id')->constrained('aset')->cascadeOnDelete();
            $table->integer('jumlah_sistem');
            $table->integer('jumlah_fisik');
            $table->enum('status_lama', ['tersedia','dipakai','rusak','hilang','habis'])->default('hilang');
            $table->enum('status_fisik', ['tersedia','dipakai','rusak','hilang','habis'])->default('hilang');
            // $table->foreign('checked_by')->references('id')->on('users')->onDelete('cascade'); //foreign key id user yang melakukan opname
            $table->foreignId('checked_by')->constrained('users')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_opname_details');
    }
};
