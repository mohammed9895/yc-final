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
            $table->string('fullname_ar')->nullable();
            $table->string('fullname_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('g_c_c_camps_tbale', function (Blueprint $table) {
            //
        });
    }
};
