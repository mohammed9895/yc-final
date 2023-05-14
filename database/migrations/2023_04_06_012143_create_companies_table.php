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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cr_number');
            $table->string('about');
            $table->string('filed');
            $table->string('owner_fullname');
            $table->string('owner_phone');
            $table->string('owner_email');
            $table->string('owner_civil_id');
            $table->string('cr_copy');
            $table->string('chamber_ceritifcate_copy');
            $table->string('VAT_ceritifcate_copy');
            $table->string('readah_ceritifcate_copy');
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->on('users')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
