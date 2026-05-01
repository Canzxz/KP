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
        Schema::create('transaksi_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_transaksi');
            $table->unsignedBigInteger('id_produk');
            $table->integer('qty');
            $table->decimal('harga', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi')->cascadeOnDelete();
            $table->foreign('id_produk')->references('id_produk')->on('produk');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_items_');
    }
};
