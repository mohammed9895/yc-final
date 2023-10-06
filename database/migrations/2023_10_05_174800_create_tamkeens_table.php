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
        Schema::create('tamkeens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('social_media_accounts')->nullable();
            $table->string('linkedin_account')->nullable();
            $table->string('resume_attachment')->nullable();
            $table->string('profile_picture_attachment')->nullable();
            $table->string('skill')->nullable();
            $table->string('scientific_field')->nullable();
            $table->string('artistic_field')->nullable();
            $table->string('engineering_field')->nullable();
            $table->string('media_field')->nullable();
            $table->string('writing_field')->nullable();
            $table->string('software_field')->nullable();
            $table->string('marketing_field')->nullable();
            $table->string('design_field')->nullable();
            $table->string('craft_field')->nullable();
            $table->string('photography_field')->nullable();
            $table->string('beauty_field')->nullable();
            $table->string('fashion_field')->nullable();
            $table->string('technical_field')->nullable();
            $table->string('other_field')->nullable();
            $table->string('primary_skill')->nullable();
            $table->string('other_skill')->nullable();
            $table->text('program_goals')->nullable();
            $table->text('how_did_you_discover_your_skill')->nullable();
            $table->date('skill_practice_duration')->nullable();
            $table->string('awards_certificates')->nullable();
            $table->string('earned_income')->nullable();
            $table->integer('freelance_experience_years')->nullable();
            $table->enum('freelance_experience_level', ['Beginner', 'Intermediate', 'Expert'])->nullable();
            $table->enum('skill_level', ['Beginner', 'Intermediate', 'Expert'])->nullable();
            $table->integer('clients_worked_with')->nullable();
            $table->decimal('financial_earnings')->nullable();
            $table->text('achievements')->nullable();
            $table->text('development_plan')->nullable();
            $table->boolean('can_manage_projects')->nullable();
            $table->boolean('can_price_services_and_market_self')->nullable();
            $table->text('self_marketing_strategy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tamkeens');
    }
};
