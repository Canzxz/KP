<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Filament\Support\Enums\MaxWidth;

class CreateTransaksi extends CreateRecord
{
    protected static string $resource = TransaksiResource::class;

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {

            // ===============================
            // DATA KASIR
            // ===============================
            $data['kasir_id'] = Auth::id();

            // ===============================
            // AMBIL ITEM DARI FORM
            // ===============================
            $items = $this->form->getState()['items'] ?? [];

            if (empty($items)) {
                Notification::make()
                    ->title('Keranjang masih kosong')
                    ->danger()
                    ->send();

                $this->halt();
            }

            // ===============================
            // VALIDASI STOK (ANTI MINUS)
            // ===============================
            foreach ($items as $item) {

                $produk = Produk::lockForUpdate()
                    ->where('id_produk', $item['id_produk'])
                    ->first();

                $qty = (int) ($item['qty'] ?? 0);

                if (! $produk) {
                    Notification::make()
                        ->title('Produk tidak ditemukan')
                        ->danger()
                        ->send();

                    $this->halt();
                }

                if ($produk->stok === 0) {
                    Notification::make()
                        ->title('Stok habis')
                        ->body("Produk {$produk->nama_produk} sudah habis")
                        ->danger()
                        ->send();

                    $this->halt();
                }

                // BOLEH sama, TIDAK BOLEH lebih
                if ($qty > $produk->stok) {
                    Notification::make()
                        ->title('Stok tidak mencukupi')
                        ->body("Stok {$produk->nama_produk} tersisa {$produk->stok}")
                        ->danger()
                        ->send();

                    $this->halt();
                }
            }

            // ===============================
            // SIMPAN TRANSAKSI
            // ===============================
            $transaksi = Transaksi::create($data);

            foreach ($items as $item) {

                TransaksiItem::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_produk'    => $item['id_produk'],
                    'qty'          => $item['qty'],
                    'harga'        => $item['harga'],
                    'subtotal'     => $item['subtotal'],
                ]);

                // Kurangi stok (AMAN)
                Produk::where('id_produk', $item['id_produk'])
                    ->decrement('stok', $item['qty']);
                
                // Catat di Riwayat Stok
                \App\Models\RiwayatStok::create([
                    'produk_id' => $item['id_produk'],
                    'jenis' => 'keluar',
                    'jumlah' => $item['qty'],
                    'keterangan' => 'Penjualan: ' . $transaksi->kode_transaksi,
                    'user_id' => Auth::id(),
                ]);
            }

            return $transaksi;
        });
    }

    /**
     * AUTO CETAK STRUK SETELAH CREATE
     */
    protected function afterCreate(): void
    {
        $this->js("
            window.open(
                '" . route('transaksi.struk', $this->record->id_transaksi) . "',
                '_blank'
            );
        ");
    }
}
