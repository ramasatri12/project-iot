<?php

namespace App\Filament\Widgets;

use App\Models\SensorReport;
use Filament\Widgets\ChartWidget;
use Filament\Notifications\Notification;

class SensorReportChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Ketinggian, pH dan Debit Air';

    protected function getData(): array
    {
        $data = SensorReport::orderBy('created_at')->get();

        if ($data->last() && $data->last()->tinggi_air > 100) {
            Notification::make()
                ->title('⚠️ Peringatan! Ketinggian Air Tinggi!')
                ->body('Ketinggian air saat ini: ' . $data->last()->tinggi_air . ' cm.')
                ->danger()
                ->send();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Ketinggian Air (cm)',
                    'data' => $data->pluck('tinggi_air')->toArray(), // Ambil nilai ketinggian air
                    'borderColor' => '#007bff',
                    'backgroundColor' => 'rgba(0, 123, 255, 0.5)',
                    'fill' => true,
                ],
            ],
            'labels' => $data->pluck('created_at')->toArray(), // Ambil waktu pencatatan
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
