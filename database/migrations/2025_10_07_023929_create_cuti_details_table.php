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
        Schema::create('cuti_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cuti_id');
            $table->date('tanggal_cuti');
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
        Schema::dropIfExists('cuti_details');
    }
};
