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
        Schema::create('mkt_kontak', function (Blueprint $table) {
            $table->id();
            $table->integer('instansi_id')->nullable();
            $table->string('nama')->nullable();
            $table->string('email')->nullable();
            $table->string('telp_1')->nullable();
            $table->string('telp_2')->nullable();
            $table->string('jabatan')->nullable();
            $table->integer('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mkt_kontak');
    }
};
