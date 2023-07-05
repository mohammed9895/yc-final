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
        Schema::create('training_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('education_type_id');
            $table->unsignedBigInteger('employee_type_id');
            $table->string('cv');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('education_type_id')->references('id')->on('education_types');
            $table->foreign('employee_type_id')->references('id')->on('employee_types');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_alppications');
    }
};
