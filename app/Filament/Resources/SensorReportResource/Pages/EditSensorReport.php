<?php

namespace App\Filament\Resources\SensorReportResource\Pages;

use App\Filament\Resources\SensorReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSensorReport extends EditRecord
{
    protected static string $resource = SensorReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
