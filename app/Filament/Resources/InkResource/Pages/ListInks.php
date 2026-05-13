<?php

namespace App\Filament\Resources\InkResource\Pages;

use App\Filament\Resources\InkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInks extends ListRecords
{
    protected static string $resource = InkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
