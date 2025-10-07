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
            $table->id(); // AUTO_INCREMENT primary key
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->unsignedInteger('jabatan_id')->nullable();
            $table->unsignedInteger('role_id')->nullable();
            $table->date('tgl_msk')->nullable();
            $table->unsignedInteger('divisi_id')->nullable();
            $table->string('password')->nullable();
            $table->string('foto')->nullable();
            $table->string('nik_poto')->nullable();
            $table->string('remember_token')->nullable();
            $table->smallInteger('status')->default(1)->nullable();
            $table->smallInteger('pic')->default(0)->nullable();

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
