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
        Schema::create('m_document_project', function (Blueprint $table) {
            $table->id(); 
            $table->string('name', 255)->nullable();
            $table->smallInteger('type')->nullable();
            $table->smallInteger('sort')->nullable();
            $table->text('step')->nullable();
            $table->smallInteger('status')->default(1);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_document_project');
    }
};
