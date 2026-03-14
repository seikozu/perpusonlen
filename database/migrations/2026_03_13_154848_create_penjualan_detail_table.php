<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('penjualan_detail', function (Blueprint $table) {
            $table->id('id_penjualan_detail'); // PK
            
            // Foreign Key ke tabel penjualan
            $table->unsignedBigInteger('id_penjualan');
            $table->foreign('id_penjualan')->references('id_penjualan')->on('penjualan')->onDelete('cascade');
            
            // Foreign Key ke tabel barang (varchar 8 sesuai ERD kamu)
            $table->string('id_barang', 8);
            $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('cascade');
            
            $table->smallInteger('jumlah'); // int2
            $table->integer('subtotal'); // int4
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_detail');
    }
};
