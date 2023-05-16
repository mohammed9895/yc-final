<?php

use App\Models\User;
use App\Models\Field;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('freelancers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('field_id');
            $table->string('civil_copy');
            $table->string('cr_copy')->nullable();
            $table->string('profile_file')->nullable();
            $table->string('profile_link')->nullable();
            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('field_id')->on('fields')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancers');
    }
};
