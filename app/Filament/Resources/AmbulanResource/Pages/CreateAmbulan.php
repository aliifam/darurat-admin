<?php

namespace App\Filament\Resources\AmbulanResource\Pages;

use App\Filament\Resources\AmbulanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAmbulan extends CreateRecord
{
    protected static string $resource = AmbulanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
