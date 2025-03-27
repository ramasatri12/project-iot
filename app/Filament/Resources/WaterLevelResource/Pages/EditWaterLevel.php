<?php

namespace App\Filament\Resources\WaterLevelResource\Pages;

use App\Filament\Resources\WaterLevelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWaterLevel extends EditRecord
{
    protected static string $resource = WaterLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
