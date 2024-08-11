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
        Schema::table('catch_the_flag_competitions', function (Blueprint $table) {
            $table->json('teammates')->nullable()->after('hashing_algorithm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catch_the_flag_competitions', function (Blueprint $table) {
            //
        });
    }
};
