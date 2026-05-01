<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Models\Produk;
use App\Models\Transaksi;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Transaksi';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?string $slug = 'transaksi';



    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()?->role === 'superadmin';
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()?->role === 'superadmin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([

            Grid::make(12)->schema([

                /* ======================
                 * KIRI - KERANJANG
                 * ====================== */
                Section::make('Transaksi')
                    ->columnSpan(7)
                    ->schema([

                        TextInput::make('kode_transaksi')
                            ->label('Kode Transaksi')
                            ->default(fn () =>
                                'TRX-' . now()->format('Ymd-His') . '-' . rand(100, 999)
                            )
                            ->disabled()
                            ->dehydrated()
                            ->required(),

                        Repeater::make('items')
                            ->label('Keranjang')
                            ->required()
                            ->minItems(1)
                            ->columns(1)
                            ->schema([

        Select::make('id_produk')
            ->label('Produk')
            ->options(fn () =>
            Produk::where('stok', '>', 0)
            ->pluck('nama_produk', 'id_produk'))
            ->searchable()
            ->preload()
            ->required()
            ->reactive()
            ->live()
            ->afterStateUpdated(function ($state, callable $set, callable $get) {

                $produk = Produk::find($state);
                if (! $produk) return;

                $set('harga', (float) $produk->harga);
                $set('qty', 1);
                $set('subtotal', (float) $produk->harga);

                // 🔥 HITUNG TOTAL
                $items = $get('../../items') ?? [];

                $total = collect($items)->sum(
                    fn ($item) => (float) ($item['subtotal'] ?? 0)
                );

                $set('../../total', $total);
            }),

        TextInput::make('qty')
            ->label('Qty')
            ->numeric()
            ->default(1)
            ->minValue(1)
            ->helperText(fn (callable $get) =>
                $get('stok') <= 0
                    ? 'Stok habis'
                    : 'Stok tersedia: ' . $get('stok'))
    ->reactive()
            ->live(debounce: 200)
            ->afterStateUpdated(function ($state, callable $set, callable $get) {

                $harga = (float) $get('harga');
                $qty   = max((int) $state, 1);

                $set('subtotal', $qty * $harga);

                // 🔥 HITUNG TOTAL
                $items = $get('../../items') ?? [];

                $total = collect($items)->sum(
                    fn ($item) => (float) ($item['subtotal'] ?? 0)
                );

                $set('../../total', $total);
            }),

        TextInput::make('harga')
            ->numeric()
            ->disabled()
            ->dehydrated()
            ->prefix('Rp'),

        TextInput::make('subtotal')
            ->numeric()
            ->disabled()
            ->dehydrated()
            ->prefix('Rp'),
    ]),

                    ]),

                /* ======================
                 * KANAN - PEMBAYARAN
                 * ====================== */
                Section::make('Pembayaran')
    ->columnSpan(5)
    ->schema([

        Select::make('metode_pembayaran')
            ->label('Metode Pembayaran')
            ->options([
                'Cash' => 'Tunai (Cash)',
                'Transfer Bank' => 'Transfer Bank',
                'QRIS' => 'QRIS',
                'Kartu Kredit/Debit' => 'Kartu Kredit/Debit',
            ])
            ->default('Cash')
            ->required(),

        TextInput::make('total')
            ->label('TOTAL')
            ->numeric()
            ->disabled()
            ->dehydrated()
            ->prefix('Rp')
            ->live()
            ->extraAttributes([
                'class' => 'text-3xl font-bold text-green-600',
            ]),

        TextInput::make('bayar')
            ->label('Bayar')
            ->numeric()
            ->required()
            ->minValue(fn ($get) => $get('total'))
            ->live(debounce: 200)
            ->prefix('Rp')
            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                $total = (float) $get('total');
                $bayar = (float) $state;

                $set('kembalian', max($bayar - $total, 0));
            }),

        TextInput::make('kembalian')
            ->label('Kembalian')
            ->numeric()
            ->disabled()
            ->dehydrated()
            ->prefix('Rp')
            ->extraAttributes([
                'class' => 'text-2xl font-semibold text-blue-600',
            ]),
    ]),

            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_transaksi')->label('Kode'),
                Tables\Columns\TextColumn::make('total')->money('IDR', true),
                Tables\Columns\TextColumn::make('bayar')->money('IDR', true),
                Tables\Columns\TextColumn::make('kembalian')->money('IDR', true),
                Tables\Columns\TextColumn::make('metode_pembayaran')
                    ->label('Metode')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Cash' => 'success',
                        'Transfer Bank' => 'info',
                        'QRIS' => 'warning',
                        'Kartu Kredit/Debit' => 'primary',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('10s')
            ->actions([
                Tables\Actions\Action::make('struk')
                    ->label('Cetak Struk')
                    ->icon('heroicon-o-printer')
                    ->url(fn ($record) => route('transaksi.struk', $record))
                    ->openUrlInNewTab(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTransaksi::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
        ];
    }
}
