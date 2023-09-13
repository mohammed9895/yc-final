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
        Schema::table('talents', function (Blueprint $table) {
            $table->string('phone')->after('personal_image');
            $table->string('email')->after('phone');
            $table->integer('status')->default(0)->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('talents', function (Blueprint $table) {
            //
        });
    }
};
