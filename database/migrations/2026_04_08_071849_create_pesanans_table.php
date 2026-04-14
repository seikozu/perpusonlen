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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('idpesanan'); 
            $table->string('nama', 255); 
            $table->timestamp('timestamp')->useCurrent(); 
            $table->integer('total');
            $table->integer('metode_bayar')->nullable(); 
            $table->smallInteger('status_bayar')->default(0); 
            $table->string('snap_token')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
