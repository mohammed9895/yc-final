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
        Schema::table('g_c_c_camps', function (Blueprint $table) {
            $table->string('orginization')->nullable();
            $table->string('shert_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('g_c_c_camps', function (Blueprint $table) {
            //
        });
    }
};
