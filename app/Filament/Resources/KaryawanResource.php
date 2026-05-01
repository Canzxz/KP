<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KaryawanResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;

class KaryawanResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationLabel = 'Manajemen User';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    /**
     * 🔒 Hanya ADMIN yang bisa melihat menu Karyawan
     */
    public static function canViewAny(): bool
    {
        return Auth::user()?->role === 'superadmin';
    }    /**
     * FORM TAMBAH / EDIT KARYAWAN
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(fn ($context) => $context === 'create')
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                    ->hiddenOn('edit'),

                Select::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'kasir' => 'Kasir',
                    ])
                    ->required(),
            ]);
    }

    /**
     * TABEL DATA KARYAWAN
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->colors([
                        'success' => 'admin',
                        'info' => 'kasir',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    /**
     * HALAMAN RESOURCE
     */
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListKaryawans::route('/'),
            'create' => Pages\CreateKaryawan::route('/create'),
            'edit'   => Pages\EditKaryawan::route('/{record}/edit'),
        ];
    }
}
