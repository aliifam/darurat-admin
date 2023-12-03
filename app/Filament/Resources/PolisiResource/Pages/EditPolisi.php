<?php

namespace App\Filament\Resources\PolisiResource\Pages;

use App\Filament\Resources\PolisiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPolisi extends EditRecord
{
    protected static string $resource = PolisiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
