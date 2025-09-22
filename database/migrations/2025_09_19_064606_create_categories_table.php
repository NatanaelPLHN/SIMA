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
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('nama')->unique();
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('category_group_id')->nullable();
            $table->string('alias')->unique();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('category_group_id')->references('id')->on('category_groups')->onDelete('set null');
            // Indexes
            $table->index(['parent_id']);
            $table->index(['category_group_id']);
            // $table->index(['nama']);
            // $table->index(['alias']);
            // $table->unique(['alias']); // Alias harus unik
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
