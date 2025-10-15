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
        Schema::table('asset_usage', function (Blueprint $table) {
            $table->integer('jumlah_digunakan')->default(1)->after('tujuan_penggunaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_usage', function (Blueprint $table) {
            $table->dropColumn('jumlah_digunakan');
        });
    }
};
