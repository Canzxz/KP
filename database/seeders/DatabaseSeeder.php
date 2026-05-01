<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. DEFINISI KATEGORI DENGAN GAMBAR REPRESENTATIF (HD)
        $katsData = [
            ['nama' => 'Semen & Pasir', 'img' => 'produks/semen.png'],
            ['nama' => 'Besi & Baja', 'img' => 'produks/besi_beton.png'],
            ['nama' => 'Cat & Cairan', 'img' => 'produks/cat_dulux.png'],
            ['nama' => 'Paku & Hardware', 'img' => 'produks/paku_beton.png'],
            ['nama' => 'Plumbing & Pipa', 'img' => 'produks/pipa_pvc.png'],
            ['nama' => 'Alat Pertukangan', 'img' => 'https://images.unsplash.com/photo-1581244276891-99577956bc93?q=80&w=800'],
            ['nama' => 'Kelistrikan', 'img' => 'https://images.unsplash.com/photo-1558211583-d28f610b15a1?q=80&w=800'],
            ['nama' => 'Lantai & Keramik', 'img' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?q=80&w=800'],
            ['nama' => 'Sanitari', 'img' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?q=80&w=800'],
            ['nama' => 'Atap & Plafon', 'img' => 'https://images.unsplash.com/photo-1632759145351-1d592919f522?q=80&w=800'],
            ['nama' => 'Kayu & Papan', 'img' => 'https://images.unsplash.com/photo-1533090161767-e6ffed986c88?q=80&w=800'],
        ];

        $kats = [];
        foreach ($katsData as $k) {
            $kats[] = Kategori::create(['nama_kategori' => $k['nama'], 'gambar' => $k['img']]);
        }

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('mamimumemo'),
            'role' => 'superadmin'
        ]);

        // 2. DAFTAR 80 PRODUK SANGAT SPESIFIK
        $inventory = [
            // SEMEN & PASIR (Kat 0)
            ['Semen Tonasa 50kg', 'Sak', 65000, 0], ['Semen Tonasa 40kg', 'Sak', 55000, 0], ['Semen Tiga Roda 50kg', 'Sak', 68000, 0], ['Semen Mortar MU-200', 'Sak', 155000, 0], ['Pasir Cor Merapi', 'M3', 285000, 0], ['Pasir Pasang Kali', 'M3', 240000, 0], ['Batu Split 1/2', 'M3', 260000, 0], ['Batu Bata Press', 'Pcs', 850, 0],

            // BESI & BAJA (Kat 1)
            ['Besi Beton 8mm SNI', 'Batang', 55000, 1], ['Besi Beton 10mm SNI', 'Batang', 78000, 1], ['Besi Beton 12mm SNI', 'Batang', 108000, 1], ['Besi Ulir 13mm SNI', 'Batang', 128000, 1], ['Hollow Galvanis 2x4 (0.3)', 'Batang', 45000, 1], ['Hollow Galvanis 4x4 (0.3)', 'Batang', 75000, 1], ['Baja WF 150 (12m)', 'Unit', 3250000, 1], ['Wiremesh M6 SNI', 'Lembar', 680000, 1],

            // CAT (Kat 2)
            ['Dulux Weathershield 20L White', 'Pail', 2480000, 2], ['Dulux Weathershield 5L Blue', 'Galon', 650000, 2], ['Avian Gloss 1L Black', 'Can', 75000, 2], ['No Drop 1kg Grey', 'Can', 68000, 2], ['Thinner A Spesial 1L', 'Btl', 28000, 2], ['Kuas Cat 2"', 'Pcs', 8500, 2], ['Kuas Cat 3"', 'Pcs', 13500, 2], ['Rol Cat Pro-Set', 'Set', 45000, 2],

            // PAKU & HARDWARE (Kat 3)
            ['Paku Kayu 2"', 'Kg', 22000, 3], ['Paku Kayu 3"', 'Kg', 22000, 3], ['Paku Kayu 4"', 'Kg', 22000, 3], ['Paku Beton 5cm Marabu', 'Box', 28000, 3], ['Paku Beton 7cm Marabu', 'Box', 35000, 3], ['Engsel Pintu Arch 4"', 'Set', 48000, 3], ['Gembok Yale 50mm', 'Pcs', 245000, 3], ['Grendel Pintu 3"', 'Pcs', 18000, 3],

            // PLUMBING (Kat 4)
            ['Pipa Rucika AW 1/2"', 'Batang', 35000, 4], ['Pipa Rucika AW 3/4"', 'Batang', 42000, 4], ['Pipa Rucika AW 1"', 'Batang', 62000, 4], ['Kran Angsa Kitchen Onda', 'Pcs', 145000, 4], ['Kran Tembok Onda 1/2"', 'Pcs', 48000, 4], ['Seal Tape Onda', 'Roll', 6500, 4], ['Fitting Tee 1/2"', 'Pcs', 5500, 4], ['Watermur 1" Rucika', 'Pcs', 18000, 4],

            // ALAT (Kat 5)
            ['Bor Bosch GSB 550', 'Unit', 685000, 5], ['Gerinda Maktec MT60', 'Unit', 560000, 5], ['Palu Kambing 1LB', 'Pcs', 45000, 5], ['Gergaji Kayu Tekiro', 'Pcs', 85000, 5], ['Meteran 5m Tajima', 'Pcs', 65000, 5], ['Tang Kombinasi 7"', 'Pcs', 55000, 5], ['Obeng Set Stanley', 'Set', 145000, 5],

            // LISTRIK (Kat 6)
            ['Lampu LED Philips 9W White', 'Pcs', 45000, 6], ['Lampu LED Philips 13W White', 'Pcs', 65000, 6], ['Kabel Eterna NYM 2x1.5 (50m)', 'Roll', 425000, 6], ['Kabel Eterna NYM 2x2.5 (50m)', 'Roll', 580000, 6], ['Saklar Broco Engkel', 'Pcs', 19500, 6], ['Stop Kontak 4 Lubang', 'Pcs', 45000, 6],

            // LANTAI (Kat 7)
            ['Keramik Mulia 40x40 Putih', 'Box', 68000, 7], ['Keramik Mulia 40x40 Beige', 'Box', 70000, 7], ['Granit Garuda 60x60 Cream', 'Box', 195000, 7], ['Granit Garuda 60x60 Grey', 'Box', 205000, 7], ['Semen Nat AM-50 White', 'Kg', 18000, 7], ['Bon-bon Keramik 10cm', 'Pcs', 3500, 7],

            // SANITARI (Kat 8)
            ['Closet TOTO CW421J Putih', 'Unit', 2650000, 8], ['Closet TOTO Jongkok CE7', 'Unit', 450000, 8], ['Wastafel TOTO LW248J', 'Unit', 1350000, 8], ['Shower Column Set Onda', 'Set', 1100000, 8], ['Floor Drain Toto', 'Pcs', 185000, 8],

            // ATAP (Kat 9)
            ['Kanal C Kencana 0.75', 'Batang', 98000, 9], ['Kanal C Kencana 0.65', 'Batang', 85000, 9], ['Reng Kencana 0.45', 'Batang', 45000, 9], ['Spandek 3m (0.3mm)', 'Lembar', 175000, 9], ['Spandek 6m (0.3mm)', 'Lembar', 345000, 9], ['Genteng Metal Pasir Maroon', 'Lembar', 42000, 9], ['Baut Roofing 5cm', 'Bks', 35000, 9],

            // KAYU (Kat 10)
            ['Triplek Meranti 3mm', 'Lembar', 58000, 10], ['Triplek Meranti 6mm', 'Lembar', 88000, 10], ['Triplek Meranti 9mm', 'Lembar', 128000, 10], ['Triplek Meranti 12mm', 'Lembar', 188000, 10], ['Kayu Usuk 4x6 Borneo', 'Batang', 48000, 10], ['Papan Kayu Pinus 2m', 'Lembar', 85000, 10], ['Lem Kayu Fox 1kg', 'Can', 35000, 10],
        ];

        foreach ($inventory as $it) {
            Produk::create([
                'nama_produk' => $it[0],
                'satuan' => $it[1],
                'harga' => $it[2],
                'stok' => rand(10, 100),
                'gambar' => $katsData[$it[3]]['img'],
                'kategori_id' => $kats[$it[3]]->id_kategori
            ]);
        }

        // 3. GENERATE TRANSAKSI HARI INI (BARU)
        $produks = Produk::all();
        for ($i = 0; $i < 12; $i++) {
            $total = 0;
            $items = [];
            $selected = $produks->random(rand(1, 3));
            
            foreach ($selected as $p) {
                $qty = rand(1, 4);
                $subtotal = $p->harga * $qty;
                $total += $subtotal;
                $items[] = [
                    'id_produk' => $p->id_produk,
                    'qty' => $qty,
                    'harga' => $p->harga,
                    'subtotal' => $subtotal
                ];
            }
            
            $t = Transaksi::create([
                'kode_transaksi' => 'TRX-' . date('Ymd') . \Illuminate\Support\Str::random(4),
                'total' => $total,
                'bayar' => $total + 50000,
                'kembalian' => 50000,
                'kasir_id' => $user->id,
                'metode_pembayaran' => 'Cash',
                'created_at' => now(),
            ]);
            
            foreach ($items as $item) {
                $item['id_transaksi'] = $t->id_transaksi;
                TransaksiItem::create($item);
            }
        }
    }
}
