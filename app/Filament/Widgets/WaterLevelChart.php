<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\WaterLevel;
use Filament\Notifications\Notification;

class WaterLevelChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Ketinggian Air';

    protected function getData(): array
    {
        $data = WaterLevel::orderBy('created_at')->get();

        if ($data->last() && $data->last()->height > 100) {
            Notification::make()
                ->title('⚠️ Peringatan! Ketinggian Air Tinggi!')
                ->body('Ketinggian air saat ini: ' . $data->last()->height . ' cm.')
                ->danger()
                ->send();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Ketinggian Air (cm)',
                    'data' => $data->pluck('height')->toArray(), // Ambil nilai ketinggian air
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
