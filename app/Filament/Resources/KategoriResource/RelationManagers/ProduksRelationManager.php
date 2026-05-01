<?php

namespace App\Filament\Resources\KategoriResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProduksRelationManager extends RelationManager
{
    protected static string $relationship = 'produks';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_produk')
                    ->label('Nama Produk')
                    ->required()
                    ->maxLength(150),

                Forms\Components\TextInput::make('satuan')
                    ->label('Satuan')
                    ->required()
                    ->maxLength(50)
                    ->placeholder('pcs / sak / meter'),

                Forms\Components\TextInput::make('harga')
                    ->label('Harga')
                    ->numeric()
                    ->required()
                    ->prefix('Rp'),

                Forms\Components\TextInput::make('stok')
                    ->label('Stok Awal')
                    ->numeric()
                    ->required()
                    ->disabledOn('edit'),

                Forms\Components\FileUpload::make('gambar')
                    ->label('Gambar Produk')
                    ->image()
                    ->disk('public')
                    ->directory('produks')
                    ->imagePreviewHeight('150')
                    ->maxSize(2048)
                    ->formatStateUsing(fn ($state) => is_array($state) ? $state : ($state ? (str_starts_with($state, 'http') ? [] : [$state]) : [])),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_produk')
            ->columns([
                Tables\Columns\TextColumn::make('nama_produk')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('satuan')
                    ->label('Satuan')
                    ->sortable(),

                Tables\Columns\TextColumn::make('harga')
                    ->label('Harga')
                    ->money('IDR', true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('stok')
                    ->label('Stok')
                    ->sortable()
                    ->badge()
                    ->color(fn($state) => $state < 5 ? 'danger' : 'success'),

                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->height(50)
                    ->circular()
                    ->getStateUsing(fn ($record) => $record->gambar ? (str_starts_with($record->gambar, 'http') ? [$record->gambar] : [asset('storage/' . $record->gambar)]) : []),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->visible(fn () => auth()->user()?->role === 'superadmin'),
            ])
            ->actions([
                Tables\Actions\Action::make('restock')
                    ->visible(fn () => auth()->user()?->role === 'superadmin')
                    ->label('Restock')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->form([
                        Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah Masuk')
                            ->numeric()
                            ->required()
                            ->minValue(1),
                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan / Supplier')
                            ->maxLength(255)
                    ])
                    ->action(function (\App\Models\Produk $record, array $data): void {
                        \App\Models\RiwayatStok::create([
                            'produk_id' => $record->id_produk,
                            'jenis' => 'masuk',
                            'jumlah' => $data['jumlah'],
                            'keterangan' => $data['keterangan'] ?? 'Restock manual via Kategori',
                            'user_id' => auth()->id(),
                        ]);
                        
                        $record->increment('stok', $data['jumlah']);
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Stok diupdate')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make()
                    ->visible(fn () => auth()->user()?->role === 'superadmin'),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => auth()->user()?->role === 'superadmin'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->role === 'superadmin'),
                ]),
            ]);
    }
}
