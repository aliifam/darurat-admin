<?php

namespace App\Filament\Resources\PolisiResource\Pages;

use App\Filament\Resources\PolisiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPolisis extends ListRecords
{
    protected static string $resource = PolisiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
