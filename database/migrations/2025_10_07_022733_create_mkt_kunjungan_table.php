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
        Schema::create('mkt_kunjungan', function (Blueprint $table) {
            $table->id();
            $table->integer('instansi_id')->nullable();
            $table->time('jam1')->nullable();
            $table->time('jam2')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('foto')->nullable();
            $table->string('dokumen')->nullable();
            $table->smallInteger('status')->nullable()->default(1);
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
        Schema::dropIfExists('mkt_kunjungan');
    }
};
