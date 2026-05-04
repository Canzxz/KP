<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Models\Produk;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables;
use Filament\Forms;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?string $navigationLabel = 'Produk';
    protected static ?string $pluralModelLabel = 'Produk';

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->role === 'superadmin';
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()?->role === 'superadmin';
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()?->role === 'superadmin';
    }

    public static function getNavigationBadge(): ?string
    {
        $lowStockCount = static::getModel()::where('stok', '<=', 10)->count();
        return $lowStockCount > 0 ? (string) $lowStockCount : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kategori_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'nama_kategori')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nama_kategori')
                            ->required(),
                    ]),

                TextInput::make('nama_produk')
                    ->label('Nama Produk')
                    ->required()
                    ->maxLength(150),

                TextInput::make('satuan')
                    ->label('Satuan')
                    ->required()
                    ->maxLength(50)
                    ->placeholder('pcs / sak / meter'),

                TextInput::make('harga')
                    ->label('Harga')
                    ->numeric()
                    ->required()
                    ->prefix('Rp'),

                TextInput::make('stok')
                    ->label('Stok Awal')
                    ->numeric()
                    ->required()
                    ->disabledOn('edit'), // Disable on edit so stock rests strictly via Restock action

                FileUpload::make('gambar')
                    ->label('Gambar Produk')
                    ->image()
                    ->disk('public')
                    ->directory('produks')
                    ->imagePreviewHeight('150')
                    ->maxSize(2048)
                    ->formatStateUsing(fn ($state) => is_array($state) ? $state : ($state ? (str_starts_with($state, 'http') ? [] : [$state]) : [])),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading(new \Illuminate\Support\HtmlString('<style> 
                /* Hilangkan wrapper utama tabel (outer border) */
                .fi-ta-ctn, .fi-ta > .fi-card, .fi-ta-content { background: transparent !important; box-shadow: none !important; border: none !important; ring: 0 !important; } 
                .fi-ta { border: none !important; }
                
                /* Hilangkan border & background header utama (Search/Filter bar) */
                .fi-ta-header { background: transparent !important; border-bottom: none !important; padding-left: 0 !important; padding-right: 0 !important; box-shadow: none !important; }
                
                /* Hilangkan thead tabel (jika ada sisa header) */
                .fi-ta-table thead { display: none !important; } 
                
                /* Hilangkan garis di grup kategori */
                .fi-ta-group-header { background: transparent !important; border-top: none !important; border-bottom: none !important; box-shadow: none !important; }
                .fi-ta-group-header td { background: transparent !important; border: none !important; }
                
                /* Hapus garis bagi (divide-y) bawaan Filament */
                .divide-y > :not([hidden]) ~ :not([hidden]) { border-color: transparent !important; }
                
                /* Animasi Hover Premium pada Kartu Produk */
                .fi-ta-content-grid > div > div {
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                    border-radius: 1.25rem !important;
                    overflow: hidden !important;
                    border: 1px solid rgba(0, 0, 0, 0.05) !important;
                    background: white !important;
                }
                .dark .fi-ta-content-grid > div > div {
                    background: rgba(30, 36, 51, 0.4) !important;
                    border: 1px solid rgba(255, 255, 255, 0.05) !important;
                    backdrop-filter: blur(10px) !important;
                }
                .fi-ta-content-grid > div > div:hover {
                    transform: translateY(-5px) !important;
                    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
                    border-color: rgba(59, 130, 246, 0.3) !important;
                }
                .dark .fi-ta-content-grid > div > div:hover {
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2) !important;
                }
                
                /* Jarak antar kartu */
                .fi-ta-content-grid { gap: 1.5rem !important; margin-top: 1rem !important; } 

                /* Menata Search & Filter di samping Sort */
                .fi-ta-header-toolbar { 
                    display: flex !important; 
                    flex-direction: row !important; 
                    align-items: center !important; 
                    gap: 1rem !important;
                    justify-content: flex-start !important;
                }
                .fi-ta-header-toolbar > div { margin: 0 !important; }
                .fi-ta-search-field { max-width: 250px !important; }

                /* Styling Tombol New Produk Premium */
                .fi-ac-btn-action, .fi-header-actions button {
                    background: #2563eb !important; /* Blue 600 - Solid & Elegant */
                    border: none !important;
                    border-radius: 0.75rem !important;
                    padding: 0.6rem 1.5rem !important;
                    font-weight: 800 !important;
                    text-transform: uppercase !important;
                    letter-spacing: 0.05em !important;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1) !important;
                    transition: all 0.2s ease !important;
                }
                .fi-ac-btn-action:hover, .fi-header-actions button:hover {
                    transform: translateY(-1px) !important;
                    background: #1d4ed8 !important; /* Darker blue on hover */
                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
                }

                /* Memindahkan Tombol ke Kiri */
                .fi-header {
                    display: flex !important;
                    flex-direction: row !important;
                    align-items: center !important;
                    justify-content: flex-start !important;
                    gap: 1.5rem !important;
                }
                .fi-header-actions {
                    order: 2 !important;
                    margin-inline-start: 0 !important;
                }
                .fi-header-heading-ctn {
                    order: 1 !important;
                }
            </style>'))
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    // Gambar Terpusat & Lebih Kecil
                    Tables\Columns\ImageColumn::make('gambar')
                        ->label('Gambar')
                        ->height('120px')
                        ->width('100%')
                        ->disk('public')
                        ->extraImgAttributes(['style' => 'object-fit: contain; width: 100%; border-radius: 0.75rem;'])
                        ->extraAttributes(['class' => 'p-4 pb-0'])
                        ->defaultImageUrl('https://ui-avatars.com/api/?name=Produk&background=1152d4&color=fff&size=512'),
                    
                    Tables\Columns\Layout\Stack::make([
                        // Kategori
                        Tables\Columns\TextColumn::make('kategori.nama_kategori')
                            ->size('xs')
                            ->color('gray')
                            ->weight('medium')
                            ->alignment('center')
                            ->extraAttributes(['class' => 'uppercase tracking-widest opacity-60 mb-1']),

                        // Nama Produk (Lebih kecil)
                        Tables\Columns\TextColumn::make('nama_produk')
                            ->weight('bold')
                            ->size('sm')
                            ->alignment('center')
                            ->searchable()
                            ->limit(35),
                        
                        // Harga & Stok
                        Tables\Columns\Layout\Stack::make([
                            Tables\Columns\TextColumn::make('harga')
                                ->money('IDR')
                                ->color('success')
                                ->weight('black')
                                ->alignment('center')
                                ->size('xs'),
                            
                            Tables\Columns\TextColumn::make('stok')
                                ->badge()
                                ->size('xs')
                                ->alignment('center')
                                ->color(fn($state) => (int)$state < 10 ? 'danger' : 'info')
                                ->formatStateUsing(fn($state) => $state . ' pcs'),
                        ])->space(1)->extraAttributes(['class' => 'mt-3 pt-2 border-t border-white/5']),
                    ])->extraAttributes(['class' => 'p-4 pt-2']), 
                ])
                ->space(0)
            ])
            ->contentGrid([
                'md' => 3,
                'xl' => 5, // Lebih banyak kolom agar kartu lebih kecil
            ])
            ->groups([
                Tables\Grouping\Group::make('kategori.nama_kategori')
                    ->label('Kategori'),
            ])
            ->defaultGroup('kategori.nama_kategori')
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->relationship('kategori', 'nama_kategori')
                    ->multiple()
                    ->searchable()
                    ->preload()
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('restock')
                        ->visible(fn () => auth()->user()?->role === 'superadmin')
                        ->label('Update Stok')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->form([
                            Forms\Components\Select::make('jenis')
                                ->label('Jenis Penyesuaian')
                                ->options([
                                    'restok' => 'Restok',
                                    'hilang/rusak' => 'Hilang/Rusak',
                                ])
                                ->default('restok')
                                ->required(),
                            Forms\Components\TextInput::make('jumlah')
                                ->label('Jumlah')
                                ->numeric()
                                ->required()
                                ->minValue(1),
                            Forms\Components\Textarea::make('keterangan')
                                ->label('Alasan Penyesuaian')
                                ->placeholder('Contoh: Barang rusak di gudang')
                                ->maxLength(255)
                        ])
                        ->action(function (Produk $record, array $data): void {
                            $jumlah = (int) $data['jumlah'];
                            if ($data['jenis'] === 'hilang/rusak') {
                                if ($record->stok < $jumlah) {
                                    \Filament\Notifications\Notification::make()
                                        ->title('Gagal: Stok Kurang')
                                        ->danger()
                                        ->send();
                                    return;
                                }
                                $record->decrement('stok', $jumlah);
                            } else {
                                $record->increment('stok', $jumlah);
                            }

                            \App\Models\RiwayatStok::create([
                                'produk_id' => $record->id_produk,
                                'jenis' => $data['jenis'] === 'restok' ? 'masuk' : 'keluar',
                                'jumlah' => $jumlah,
                                'keterangan' => $data['keterangan'] ?? 'Manual update',
                                'user_id' => auth()->id(),
                            ]);

                            \Filament\Notifications\Notification::make()
                                ->title('Stok Diperbarui')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->icon('heroicon-m-ellipsis-vertical')
                  ->color('gray')
                  ->button()
                  ->label('Opsi')
            ])
            ->defaultPaginationPageOption('all')
            ->poll('10s')
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}