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
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->nullable()->after('id');
            $table->foreign('department_id')->references('id')->on('departements')->onDelete('set null');
            $table->unsignedBigInteger('institution_id')->nullable()->after('id');
            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('set null');

        });
        Schema::table('institutions', function (Blueprint $table) {
            // 1. Hapus kolom string yang lama jika masih ada
            // if (Schema::hasColumn('institutions', 'kepala_instansi')) {
            //     $table->dropColumn('kepala_instansi');
            // }

            // 2. Tambahkan kolom foreign key yang baru
            $table->foreignId('kepala_instansi_id')->nullable()->constrained('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn('department_id');
            $table->dropForeign(['institution_id']);
            $table->dropColumn('institution_id');
        });
        Schema::table('institutions', function (Blueprint $table) {
            // Logika untuk membatalkan migrasi (rollback)
            $table->dropForeign(['kepala_instansi_id']);
            $table->dropColumn('kepala_instansi_id');

            $table->string('kepala_instansi')->nullable();
        });
    }
};
