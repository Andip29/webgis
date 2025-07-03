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
        Schema::table('calon_pelanggans', function (Blueprint $table) {
            $table->unsignedBigInteger('odp_id')->nullable();
            $table->foreign('odp_id')->references('id')->on('odps')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calon_pelanggans', function (Blueprint $table) {
            //
        });
    }
};
