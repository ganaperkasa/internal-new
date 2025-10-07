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
        Schema::create('settings', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('last_number_sep')->nullable();
            $table->dateTime('last_sep_update')->nullable();
            $table->integer('last_number_dir')->nullable();
            $table->dateTime('last_dir_update')->nullable();
            $table->integer('last_number_msk')->nullable();
            $table->dateTime('last_msk_update')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
