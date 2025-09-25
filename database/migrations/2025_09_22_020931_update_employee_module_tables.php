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
        Schema::rename('employees', 'karyawan');

        Schema::table('users', function (Blueprint $table) {
            // Add nullable relation so not every user must have karyawan
            $table->foreignId('karyawan_id')
                ->nullable()
                ->constrained('karyawan')
                ->nullOnDelete();
        });

        Schema::table('bidang', function (Blueprint $table) {
            // Drop old foreign key and column
            $table->dropForeign(['instansi_id']);
            $table->dropColumn('instansi_id');

            // Recreate with foreignId
            $table->foreignId('instansi_id')
                  ->constrained('instansi')
                  ->cascadeOnDelete();

            // Replace kepala_bidang with a foreignId to karyawan
            $table->dropColumn('kepala_bidang');
            $table->foreignId('kepala_bidang_id')
                  ->nullable()
                  ->constrained('karyawan')
                  ->nullOnDelete();
        });

        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropColumn('email');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bidang', function (Blueprint $table) {

            // Rollback kepala_bidang_id
            $table->dropForeign(['kepala_bidang_id']);
            $table->dropColumn('kepala_bidang_id');

            // Rollback instansi_id
            $table->dropForeign(['instansi_id']);
            $table->dropColumn('instansi_id');

            // Restore original columns
            $table->unsignedBigInteger('instansi_id');
            $table->string('kepala_bidang')->nullable();

            $table->foreign('instansi_id')
                  ->references('id')
                  ->on('instansi')
                  ->onDelete('cascade');

            Schema::rename('karyawan', 'employees');

            Schema::table('karyawan', function (Blueprint $table) {
                $table->dropColumn('email');
            });

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        });
    }
};
