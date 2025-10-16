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

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
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
