<?php

namespace App\Filament\Resources;

use App\Models\Produk;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\StokResource\Pages;
use Illuminate\Http\Request;
class StokResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationLabel = 'Stok Produk';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?int $navigationSort = 2;
    protected static ?string $pluralLabel = 'Stok Produk';
    
    /**
     * 🔒 Hanya ADMIN boleh lihat menu Stok
     */
    public static function canViewAny(): bool
    {
        return false;
    }

    /**
     * ❌ Disable Create
     */
    public static function canCreate(): bool
    {
        return false;
    }

    /**
     * ❌ Disable Edit
     */
    public static function canEdit($record): bool
    {
        return false;
    }

    /**
     * ❌ Disable Delete
     */
    public static function canDelete($record): bool
    {
        return false;
    }
    
    public static function table(Table $table): Table
{
    return $table
        ->columns([
            ViewColumn::make('stok_card')
                ->view('filament.stok-card'),
        ])
        ->contentGrid([
            'md' => 3,
            'lg' => 5,
            'xl' => 6,
        ])
        ->paginated([12])
        ->actions([])
        ->bulkActions([]);
}
    public static function getPages(): array
    {
        return [
            'index' => Pages\StokCard::route('/'),
        ];
    }
}
