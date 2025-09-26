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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('category_group_id')->nullable();
            $table->string('alias')->unique();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('category_group_id')->references('id')->on('category_groups')->onDelete('set null');
            // Indexes
            $table->index(['category_group_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void        
    {
        Schema::dropIfExists('categories');
    }
};
