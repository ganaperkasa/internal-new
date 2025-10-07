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
        Schema::create('adm_project_document', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable();
            $table->integer('document_id')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('file')->nullable();
            $table->text('revisi')->nullable();
            $table->smallInteger('konfirmasi')
                  ->nullable()
                  ->default(0)
                  ->comment('0: Belum, 1: Konfirmasi, 2: Revisi');
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adm_project_document');
    }
};
