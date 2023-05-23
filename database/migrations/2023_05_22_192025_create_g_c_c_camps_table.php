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
        Schema::create('g_c_c_camps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->boolean('has_heart_issues');
            $table->boolean('has_respiratory_issues');
            $table->text('crisis_stage')->nullable();
            $table->boolean('has_diabetes');
            $table->boolean('has_head_injury');
            $table->text('head_injury_details')->nullable();
            $table->boolean('is_registered_disabled');
            $table->boolean('has_bone_or_tendon_injury');
            $table->text('bone_tendon_injury_details')->nullable();
            $table->boolean('has_infectious_disease');
            $table->text('infectious_disease_details')->nullable();
            $table->string('blood_type')->nullable();
            $table->boolean('had_medical_treatment');
            $table->text('medical_treatment_details')->nullable();
            $table->text('medications')->nullable();
            $table->text('other_medical_issues')->nullable();
            $table->text('diet')->nullable();
            $table->text('fears')->nullable();
            $table->foreign('user_id')->on('users')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('g_c_c_camps');
    }
};
