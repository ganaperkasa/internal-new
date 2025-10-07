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
        Schema::create('m_instansi', function (Blueprint $table) {
            $table->id(); 
            $table->string('name')->nullable();
            $table->string('type')->nullable()->comment('1:Pemerintah Daerah, 2:BUMD, 3:BUMN, 4:Swasta');
            $table->string('email')->nullable();
            $table->string('telp')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_instansi');
    }
};
