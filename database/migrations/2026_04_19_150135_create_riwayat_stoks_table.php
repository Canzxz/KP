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
        Schema::create('riwayat_stok', function (Blueprint $table) {
            $table->id('id_riwayat');
            $table->unsignedBigInteger('produk_id');
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->integer('jumlah');
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('produk_id')->references('id_produk')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_stok');
    }
};
