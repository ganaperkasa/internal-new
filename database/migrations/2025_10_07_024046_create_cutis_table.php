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
        Schema::create('cutis', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('user_cuti');
            $table->unsignedBigInteger('user_pj');
            $table->unsignedBigInteger('user_setuju');
            $table->unsignedBigInteger('user_tau');
            $table->longText('keterangan');
            $table->string('file', 255)->nullable();
            $table->string('file_terima', 255)->nullable();
            $table->integer('sisa')->nullable();
            $table->integer('dipakai')->nullable();
            $table->enum('status', ['0', '1'])
                  ->default('0')
                  ->comment('0 => belum disetujui | 1 => sudah');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cutis');
    }
};
