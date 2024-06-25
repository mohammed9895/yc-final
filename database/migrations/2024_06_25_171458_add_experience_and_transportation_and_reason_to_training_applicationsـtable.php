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
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_applications', function (Blueprint $table) {
            $table->integer('experience')->after('employee_type_id');
            $table->string('transportation')->after('experience');
            $table->integer('reason')->after('reason');
        });
    }
};
