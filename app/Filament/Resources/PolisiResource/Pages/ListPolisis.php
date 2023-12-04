<?php

namespace App\Filament\Resources\PolisiResource\Pages;

use App\Filament\Resources\PolisiResource;
use App\Filament\Resources\PolisiResource\Widgets\PolisiMap;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPolisis extends ListRecords
{
    protected static string $resource = PolisiResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            PolisiMap::make(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
