<?php

namespace App\Filament\Resources\FiliarResource\Pages;

use App\Filament\Resources\FiliarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFiliar extends EditRecord
{
    protected static string $resource = FiliarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
