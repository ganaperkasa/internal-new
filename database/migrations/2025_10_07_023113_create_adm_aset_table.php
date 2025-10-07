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
        Schema::create('adm_aset', function (Blueprint $table) {
            $table->id();
            $table->integer('barang_id')->nullable();
            $table->integer('instansi_id')->nullable();
            $table->string('number', 50)->nullable();
            $table->string('name')->nullable()->comment('Nama Merk');
            $table->double('nominal')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('spesifikasi')->nullable();
            $table->string('kondisi')->nullable();
            $table->string('document')->nullable();
            $table->date('tanggal_pembelian')->nullable();
            $table->date('tanggal_penerimaan')->nullable();
            $table->char('time_perawatan', 30)->nullable();
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
        Schema::dropIfExists('adm_aset');
    }
};
