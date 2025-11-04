<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('asset_usage', function (Blueprint $table) {
            // sesuaikan tipe foreign key: jika Anda menyimpan employees.id
            $table->unsignedBigInteger('pic_id')->nullable()->after('department_id');

            // opsional: foreign key constraint
            $table->foreign('pic_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('asset_usage', function (Blueprint $table) {
            $table->dropForeign(['pic_id']);
            $table->dropColumn('pic_id');
        });
    }
};
