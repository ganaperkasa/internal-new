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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('tempat')->nullable();
            $table->text('perihal')->nullable();
            $table->string('pelaksana')->nullable();
            $table->time('jam1')->nullable();
            $table->time('jam2')->nullable();
            $table->timestamp('updated_at')
                  ->useCurrent()
                  ->useCurrentOnUpdate();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('user_by')->nullable();
            $table->smallInteger('status')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
