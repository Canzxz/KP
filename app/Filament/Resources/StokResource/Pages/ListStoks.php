<?php

namespace App\Filament\Resources\StokResource\Pages;

use App\Filament\Resources\StokResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Produk;

class ListStoks extends ListRecords
{
    protected static string $resource = StokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }protected function hasTable(): bool
    {
        return false; // ⛔ MATIKAN TABLE
    }
}
