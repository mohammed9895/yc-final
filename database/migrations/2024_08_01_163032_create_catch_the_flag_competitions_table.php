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
        Schema::create('catch_the_flag_competitions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('previous_participation');
            $table->string('open_source_usage');
            $table->text('kali_linux_usage');
            $table->text('ethical_hacking_definition');
            $table->string('network_scanning_tool');
            $table->string('password_cracking_tool');
            $table->string('cyber_attack_type');
            $table->text('metasploit_usage');
            $table->string('other_os_for_pentesting');
            $table->string('hashing_algorithm');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catch_the_flag_competitions');
    }
};
