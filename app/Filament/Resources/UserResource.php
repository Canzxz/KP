<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Menu';
    protected static ?string $navigationLabel = 'Manajemen User';
    protected static ?string $pluralModelLabel = 'User';
    protected static ?int $navigationSort = 99;

    // Hanya Super Admin yang bisa mengakses
    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->role === 'superadmin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrateStateUsing(fn ($state) => $state ? Hash::make($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->helperText(fn (string $operation) => $operation === 'edit' ? 'Kosongkan jika tidak ingin mengubah password' : null)
                            ->maxLength(255),

                        Forms\Components\Select::make('role')
                            ->label('Role')
                            ->options([
                                'superadmin' => 'Super Admin',
                                'kasir' => 'Kasir',
                            ])
                            ->default('kasir')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'superadmin' => 'danger',
                        'kasir' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'superadmin' => 'Super Admin',
                        'kasir' => 'Kasir',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('10s')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (User $record) {
                        // Mencegah menghapus diri sendiri
                        if ($record->id === auth()->id()) {
                            \Filament\Notifications\Notification::make()
                                ->title('Gagal')
                                ->body('Anda tidak dapat menghapus akun Anda sendiri.')
                                ->danger()
                                ->send();
                            return false;
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
