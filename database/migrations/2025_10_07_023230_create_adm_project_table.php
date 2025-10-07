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
        Schema::create('adm_project', function (Blueprint $table) {
            $table->id();
            $table->integer('instansi_id')->nullable();
            $table->string('name')->nullable()->comment('Nama Project');
            $table->string('label')->nullable();
            $table->double('nominal')->nullable();
            $table->string('perusahaan')->nullable();
            $table->integer('type_project_id')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->char('time', 30)->nullable();
            $table->char('progress', 30)->nullable();
            $table->text('catatan')->nullable();
            $table->integer('marketing_id')->nullable();
            $table->char('time_type', 30)->nullable();
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
        Schema::dropIfExists('adm_project');
    }
};
