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
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id('iddetail_pesanan'); 
            $table->unsignedBigInteger('idmenu'); 
            $table->unsignedBigInteger('idpesanan'); 
            $table->integer('jumlah'); 
            $table->integer('harga'); 
            $table->integer('subtotal'); 
            $table->timestamp('timestamp')->useCurrent(); 
            $table->string('catatan', 255)->nullable(); 
            
            $table->foreign('idmenu')->references('idmenu')->on('menus');
            $table->foreign('idpesanan')->references('idpesanan')->on('pesanans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};
