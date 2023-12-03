<?php

namespace App\Filament\Resources\PemadamResource\Pages;

use App\Filament\Resources\PemadamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPemadams extends ListRecords
{
    protected static string $resource = PemadamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
