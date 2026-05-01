<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriResource\Pages;
use App\Filament\Resources\KategoriResource\RelationManagers;
use App\Models\Kategori;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KategoriResource extends Resource
{
    protected static ?string $model = Kategori::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?int $navigationSort = 1;

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->hidden(fn () => auth()->user()?->role !== 'superadmin')
                    ->schema([
                        Forms\Components\TextInput::make('nama_kategori')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('gambar')
                            ->image()
                            ->directory('kategori')
                            ->maxSize(2048)
                            ->formatStateUsing(fn ($state) => is_array($state) ? $state : ($state ? (str_starts_with($state, 'http') ? [] : [$state]) : [])),
                        Forms\Components\Textarea::make('keterangan')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
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
                
                /* Hapus garis bagi (divide-y) bawaan Filament */
                .divide-y > :not([hidden]) ~ :not([hidden]) { border-color: transparent !important; }
                
                /* Animasi Hover Premium pada Kartu Kategori */
                .fi-ta-content-grid > div > div {
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                }
                .fi-ta-content-grid > div > div:hover {
                    transform: translateY(-4px) !important;
                    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.2) !important;
                    border-color: rgba(255, 255, 255, 0.1) !important;
                }
                
                /* Jarak antar kartu */
                .fi-ta-content-grid { gap: 1.5rem !important; margin-top: 1rem !important; } 
            </style>'))
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\ImageColumn::make('gambar')
                        ->height('200px')
                        ->width('100%')
                        ->getStateUsing(function ($record) {
                            $gambar = $record->gambar;
                            $path = is_array($gambar) ? ($gambar[0] ?? null) : $gambar;
                            if (!$path) return [];
                            return str_starts_with($path, 'http') ? [$path] : [asset('storage/' . $path)];
                        })
                        ->extraImgAttributes(['style' => 'object-fit: cover; border-radius: 0.75rem 0.75rem 0 0;'])
                        ->defaultImageUrl('https://ui-avatars.com/api/?name=Category&background=3b82f6&color=fff&size=400'),
                    
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('nama_kategori')
                            ->weight('bold')
                            ->size('lg')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('keterangan')
                            ->color('gray')
                            ->limit(60),
                        Tables\Columns\TextColumn::make('produks_count')
                            ->counts('produks')
                            ->badge()
                            ->formatStateUsing(fn ($state) => $state . ' Produk'),
                    ])->space(2)->extraAttributes(['class' => 'p-4']),
                ])->space(0)
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultPaginationPageOption('all')
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProduksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKategoris::route('/'),
            'create' => Pages\CreateKategori::route('/create'),
            'view' => Pages\ViewKategori::route('/{record}'),
            'edit' => Pages\EditKategori::route('/{record}/edit'),
        ];
    }
}
