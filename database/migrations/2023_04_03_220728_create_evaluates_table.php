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
        Schema::create('evaluates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('workshop_id');

            $table->string('rating');
            $table->string('instructor');
            $table->string('duration');
            $table->string('sutsfing');
            $table->text('devloped');
            $table->text('suggestions');

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('workshop_id')->on('workshops')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluates');
    }
};
