<?php

namespace App\Filament\Resources\RiwayatStokResource\Pages;

use App\Filament\Resources\RiwayatStokResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatStoks extends ListRecords
{
    protected static string $resource = RiwayatStokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
