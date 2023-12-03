<?php

namespace App\Filament\Resources\AmbulanResource\Pages;

use App\Filament\Resources\AmbulanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAmbulans extends ListRecords
{
    protected static string $resource = AmbulanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
