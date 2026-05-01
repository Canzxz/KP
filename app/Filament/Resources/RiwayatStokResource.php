<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiwayatStokResource\Pages;
use App\Models\RiwayatStok;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RiwayatStokResource extends Resource
{
    protected static ?string $model = RiwayatStok::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?string $navigationLabel = 'Riwayat Stok';
    protected static ?int $navigationSort = 3;

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'superadmin';
    }

    // Make this resource read-only from the panel
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('produk.nama_produk')
                    ->label('Produk')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'masuk' => 'success',
                        'keluar' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => strtoupper($state)),
                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Oleh')
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('jenis')
                    ->options([
                        'masuk' => 'Barang Masuk',
                        'keluar' => 'Barang Keluar',
                    ]),
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRiwayatStoks::route('/'),
        ];
    }
}
