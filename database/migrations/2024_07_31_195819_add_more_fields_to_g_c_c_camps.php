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
            $table->string('why_you_want_to_register')->nullable();
            $table->string('goals')->nullable();
            $table->string('experience')->nullable();
            $table->string('talents')->nullable();
            $table->string('suggestions')->nullable();
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
