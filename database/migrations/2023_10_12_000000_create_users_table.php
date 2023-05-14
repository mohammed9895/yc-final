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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone');
            $table->string('birth_date');

            $table->integer('gender');
            $table->integer('citizen');
            $table->string('civil_no');

            $table->unsignedBigInteger('disability_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('education_type_id');
            $table->unsignedBigInteger('employee_type_id');

            $table->foreign('disability_id')->references('id')->on('disabilities');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('education_type_id')->references('id')->on('education_types');
            $table->foreign('employee_type_id')->references('id')->on('employee_types');

            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
