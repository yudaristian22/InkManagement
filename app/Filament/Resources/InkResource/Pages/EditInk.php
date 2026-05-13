<?php

namespace App\Filament\Resources\InkResource\Pages;

use App\Filament\Resources\InkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInk extends EditRecord
{
    protected static string $resource = InkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
