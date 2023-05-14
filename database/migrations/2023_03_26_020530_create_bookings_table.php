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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workshop_id');
            $table->unsignedBigInteger('slot_id');
            $table->unsignedBigInteger('user_id');
            $table->text('reasone');
            $table->text('rejection_message')->nullable();
            $table->integer('status')->default(0);

            $table->foreign('workshop_id')->references('id')->on('workshops');
            $table->foreign('slot_id')->references('id')->on('slots');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
