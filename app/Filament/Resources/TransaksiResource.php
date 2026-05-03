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

            Grid::make(1)->schema([

                /* ======================
                 * ATAS - KERANJANG
                 * ====================== */
                Section::make('Transaksi')
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
                            ->label('Keranjang Belanja')
                            ->relationship()
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        Select::make('id_produk')
                                            ->label('Pilih Produk')
                                            ->columnSpan(2)
                                            ->options(fn () => Produk::where('stok', '>', 0)->pluck('nama_produk', 'id_produk'))
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->reactive()
                                            ->live()
                                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                                $produk = Produk::find($state);
                                                if (!$produk) return;
                                                $set('harga', (float) $produk->harga);
                                                $set('qty', 1);
                                                $set('subtotal', (float) $produk->harga);
                                                
                                                $items = $get('../../items') ?? [];
                                                $total = collect($items)->sum(fn ($item) => (float) ($item['subtotal'] ?? 0));
                                                $set('../../total', $total);
                                            }),

                                        TextInput::make('qty')
                                            ->label('Jumlah')
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(1)
                                            ->columnSpan(1)
                                            ->reactive()
                                            ->live(debounce: 200)
                                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                                $harga = (float) $get('harga');
                                                $qty   = max((int) $state, 1);
                                                $set('subtotal', $qty * $harga);
                                                
                                                $items = $get('../../items') ?? [];
                                                $total = collect($items)->sum(fn ($item) => (float) ($item['subtotal'] ?? 0));
                                                $set('../../total', $total);
                                            }),

                                        TextInput::make('subtotal')
                                            ->label('Subtotal')
                                            ->columnSpan(1)
                                            ->numeric()
                                            ->disabled()
                                            ->dehydrated()
                                            ->prefix('Rp')
                                            ->extraInputAttributes(['class' => 'font-bold text-blue-500']),
                                    ]),
                                
                                TextInput::make('harga')
                                    ->hidden()
                                    ->dehydrated(),
                            ])
                            ->itemLabel(fn (array $state): ?string => Produk::find($state['id_produk'] ?? null)?->nama_produk ?? 'Pilih Produk')
                            ->collapsible()
                            ->collapsed(false)
                            ->cloneable()
                            ->addActionLabel('Tambah Produk Lain')
                            ->columns(1),

                    ]),

                /* ======================
                 * BAWAH - PEMBAYARAN
                 * ====================== */
                Section::make('Pembayaran')
                    ->description('Penyelesaian transaksi & pembayaran')
                    ->icon('heroicon-m-credit-card')
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
                            ->required()
                            ->native(false),

                        TextInput::make('total')
                            ->label('Total Belanja')
                            ->numeric()
                            ->disabled()
                            ->dehydrated()
                            ->prefix('Rp')
                            ->live()
                            ->extraAttributes([
                                'class' => 'text-3xl font-black text-emerald-500 bg-emerald-500/5 py-4 rounded-xl border border-emerald-500/10 text-center',
                            ]),

                        Grid::make(2)->schema([
                            TextInput::make('bayar')
                                ->label('Nominal Bayar')
                                ->numeric()
                                ->required()
                                ->placeholder('0')
                                ->minValue(fn ($get) => $get('total'))
                                ->live(debounce: 300)
                                ->prefix('Rp')
                                ->extraInputAttributes(['class' => 'text-xl font-bold text-blue-500'])
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
                                ->placeholder('0')
                                ->extraAttributes([
                                    'class' => 'text-xl font-bold text-slate-400 bg-slate-500/5 rounded-xl border border-slate-500/10',
                                ]),
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
