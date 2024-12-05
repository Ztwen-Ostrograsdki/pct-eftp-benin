<?php

namespace App\Filament\Resources\FiliarResource\Pages;

use App\Filament\Resources\FiliarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFiliars extends ListRecords
{
    protected static string $resource = FiliarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
