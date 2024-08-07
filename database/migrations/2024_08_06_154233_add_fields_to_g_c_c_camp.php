<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('g_c_c_camps', function (Blueprint $table) {
            $table->string('nationality')->nullable();
            $table->string('full_address')->nullable();
            $table->string('airport')->nullable();
            $table->string('fitness')->nullable();
            $table->string('cv')->nullable();
            $table->string('id_card')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('g_c_c_camp', function (Blueprint $table) {
            //
        });
    }
};
