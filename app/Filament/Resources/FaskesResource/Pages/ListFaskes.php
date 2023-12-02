<?php

namespace App\Filament\Resources\FaskesResource\Pages;

use App\Filament\Resources\FaskesResource;
use App\Filament\Resources\FaskesResource\Widgets\FaskesMap;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFaskes extends ListRecords
{
    protected static string $resource = FaskesResource::class;

    //header widget
    protected function getHeaderWidgets(): array
    {
        return [
            FaskesMap::make(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
