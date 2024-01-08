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
        Schema::create('cybersecurities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->boolean('tried_linux')->nullable(); // Question 1
            $table->boolean('passionate_cyber_security')->nullable(); // Question 2
            $table->enum('academic_professional_status', [ // Question 3
                'diploma_holder',
                'senior_year_student',
                'fresh_graduate',
                'cyber_analyst',
                'other'
            ])->nullable();
            $table->enum('linux_expertise', [ // Question 4
                'zero_knowledge',
                'low_knowledge',
                'medium_knowledge',
                'high_knowledge'
            ])->nullable();
            $table->boolean('participated_in_workshops')->nullable(); // Question 5 (new)
            $table->text('significant_project_description')->nullable();
            $table->string('motivation_participation', 600)->nullable(); // Question 5 (new)
            $table->string('reason_for_opportunity', 600)->nullable(); // Question 6 (new)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cybersecurities');
    }
};
