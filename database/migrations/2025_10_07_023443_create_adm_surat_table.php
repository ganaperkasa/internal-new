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
        Schema::create('adm_surat', function (Blueprint $table) {
            $table->id();
            $table->string('number', 25)->nullable();
            $table->string('msk_char', 2)->nullable();
            $table->integer('instansi_id')->nullable();
            $table->string('address')->nullable();
            $table->text('perihal')->nullable();
            $table->char('type', 10)->nullable()->comment('SEP, DIR, MSK');
            $table->date('tanggal')->nullable();
            $table->string('document')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->smallInteger('status')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adm_surat');
    }
};
