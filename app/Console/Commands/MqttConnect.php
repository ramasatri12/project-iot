<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SensorReport;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use Illuminate\Support\Facades\Log;
use App\Services\CallMeBotService;

class MqttConnect extends Command
{
     protected $signature = 'sensor:fake';
    protected $description = 'Generate fake sensor data';

    public function handle()
    {
        $data = [
            'tinggi_air' => rand(50, 250),
            'ph' => rand(50, 90) / 10, // 5.0 - 9.0
            'debit' => rand(100, 400) / 10, // 10.0 - 40.0
        ];

        $data['status'] = $data['tinggi_air'] > 200 ? 'critical' : ($data['tinggi_air'] > 100 ? 'warning' : 'normal');

        SensorReport::create($data);

        $this->info("✅ Data fake created: " . json_encode($data));
    }
}