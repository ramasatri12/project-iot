<?php

namespace App\Filament\Resources\SensorReportResource\Pages;

use App\Filament\Resources\SensorReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSensorReports extends ListRecords
{
    protected static string $resource = SensorReportResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
