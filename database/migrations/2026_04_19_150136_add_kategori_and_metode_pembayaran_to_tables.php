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
        Schema::table('produk', function (Blueprint $table) {
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->foreign('kategori_id')->references('id_kategori')->on('kategori')->onDelete('set null');
        });

        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('metode_pembayaran')->default('Cash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn('metode_pembayaran');
        });

        Schema::table('produk', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });
    }
};
